(function ($) {
    // activity plugin
    $.activity = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.activity');
            return false;
        }
    };

    // Default settings
    var defaults = {
        listSelector: '[data-activity="list"]',
        parentSelector: '[data-activity="parent"]',
        appendSelector: '[data-activity="append"]',
        formSelector: '[data-activity="form"]',
        contentSelector: '[data-activity="content"]',
        toolsSelector: '[data-activity="tools"]',
        formGroupSelector: '[data-activity="form-group"]',
        errorSummarySelector: '[data-activity="form-summary"]',
        errorSummaryToggleClass: 'hidden',
        errorClass: 'has-error',
        offset: 0
    };

    // Edit the activity
    $(document).on('click', '[data-activity="update"]', function (evt) {
        evt.preventDefault();

        $.activity('createForm');        

        var data = $.data(document, 'activity'),
            $this = $(this),
            $append = $this.parents(data.appendSelector);

        $.ajax({
            url: $this.data('activity-fetch-url'),
            type: 'PUT',
            data: {"id" : $this.data('activity-id')},
            error: function (xhr, status, error) {
                alert(error);
            },
            success: function (response, status, xhr) {
                $append.append(response);
            }
        });
    });

    // Delete activity
    $(document).on('click', '[data-activity="delete"]', function (evt) {
        evt.preventDefault();

        var data = $.data(document, 'activity'),
            $this = $(this);

        if (confirm($this.data('activity-confirm'))) {
            $.ajax({
                url: $this.data('activity-url'),
                type: 'DELETE',
                error: function (xhr, status, error) {
                    alert('error');
                },
                success: function (result, status, xhr) {
                    console.log(result);
                    console.log($this.parents('[data-activity="parent"][data-activity-id="' + $this.data('activity-id') + '"]'));
                    $this.parents('[data-activity="parent"][data-activity-id="' + $this.data('activity-id') + '"]').find(data.contentSelector).text(result);
                    $this.parents(data.toolsSelector).remove();
                }
            });
        }
    });

    // AJAX updating form submit
    $(document).on('submit', '[data-activity-action="update"]', function (evt) {
        evt.preventDefault();

        var data = $.data(document, 'activity'),
            $this = $(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT',
            data: $(this).serialize(),
            beforeSend: function (xhr, settings) {
                $this.find('[type="submit"]').attr('disabled', true);
            },
            complete: function (xhr, status) {
                $this.find('[type="submit"]').attr('disabled', false);
            },
            error: function (xhr, status, error) {
                if (xhr.status === 400) {
                    $.activity('updateErrors', $this, xhr.responseJSON);
                } else {
                    alert(error);
                }
            },
            success: function (response, status, xhr) {
                $this.parents('[data-activity="parent"][data-activity-id="' + $this.data('activity-id') + '"]').html(response);
                $.activity('removeForm');
            }
        });
    });

    // AJAX create form submit
    $(document).on('submit', '[data-activity-action="create"]', function (evt) {
        evt.preventDefault();

        var data = $.data(document, 'activity'),
            $this = $(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            beforeSend: function (xhr, settings) {
                $this.find('[type="submit"]').attr('disabled', true);
            },
            complete: function (xhr, status) {
                $this.find('[type="submit"]').attr('disabled', false);
            },
            error: function (xhr, status, error) {
                if (xhr.status === 400) {
                    $.activity('updateErrors', $this, xhr.responseJSON);
                } else {
                    alert(error);
                }
            },
            success: function (response, status, xhr) {
                $(data.listSelector).html(response);
                $.activity('clearErrors', $this);
                $this.trigger('reset');
            }
        });
    });

    // Methods
    var methods = {
        init: function (options) {
            if ($.data(document, 'activity') !== undefined) {
                return;
            }

            // Set plugin data
            $.data(document, 'activity', $.extend({}, defaults, options || {}));

            return this;
        },
        destroy: function () {
            $(document).unbind('.activity');
            $(document).removeData('activity');
        },
        data: function () {
            return $.data(document, 'activity');
        },
        createForm: function () {
            var data = $.data(document, 'activity'),
                $form = $(data.formSelector),
                $clone = $form.clone();

            methods.removeForm();

            $clone.removeAttr('id');
            $clone.attr('data-activity', 'js-form');

            data.clone = $clone;
        },
        removeForm: function () {
            var data = $.data(document, 'activity');

            if (data.clone !== undefined) {
                $('[data-activity="js-form"]').remove();
                data.clone = undefined;
            }
        },
        scrollTo: function (id) {
            var data = $.data(document, 'activity'),
                topScroll = $('[data-activity="parent"][data-activity-id="' + id + '"]').offset().top;
            $('body, html').animate({
                scrollTop: topScroll - data.offset
            }, 500);
        },
        updateErrors: function ($form, response) {
            var data = $.data(document, 'activity'),
                message = '';

            $.each(response, function (id, msg) {
                $('#' + id).closest(data.formGroupSelector).addClass(data.errorClass);
                message += msg;
            });

            $form.find(data.errorSummarySelector).toggleClass(data.errorSummaryToggleClass).text(message);
        },
        clearErrors: function ($form) {
            var data = $.data(document, 'activity');

            $form.find('.' + data.errorClass).removeClass(data.errorClass);
            $form.find(data.errorSummarySelector).toggleClass(data.errorSummaryToggleClass).text('');
        }
    };
})(window.jQuery);