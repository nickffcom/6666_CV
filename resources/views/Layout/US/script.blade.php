<script>
        /* global PNotify */
        // pnotify
        PNotify.prototype.options.styling = 'bootstrap3'

        function api (t) {
            return '/api/' + t;
        }

        $.ajaxSetup({
            beforeSend: () => {
                $('button').prop('disabled', 1);
            },
            complete: () => {
                $('button').prop('disabled', 0);
            }
        });
        $.ajaxSetup({
            headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        function showNotify (o) {
            var opts = {
                animate_speed: 'fast',
                buttons: {
                    closer: true,
                    sticker: false
                }
            }
            if (arguments.length > 1) {
                if (arguments.length === 2) {
                    o = {
                        type: arguments[0],
                        text: arguments[1]
                    }
                } else {
                    o = {
                        type: arguments[0],
                        title: arguments[1],
                        text: arguments[2]
                    }
                }
            } else {
                if (typeof(o) === 'string') {
                    o = {
                        type: 'info',
                        text: o
                    }
                }
            }
            opts = Object.assign(opts, o)
            if (!opts.hide) {
                opts.animation = 'none'
            }
            var notice = new PNotify(opts)
            if (o.clickToClose !== false) {
                notice.get().click(function() {
                    notice.remove()
                })
            }
            return notice
        }
    </script>