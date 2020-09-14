<!-- Vendor js -->
<script src="{{ asset('assets/js/vendor.min.js') }}"></script>

@stack('js')

<!-- App js-->
<script src="{{ asset('assets/js/app.min.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let isConfirm = (form) => {
        event.preventDefault();
        swal({
            title: "{{ trans('global.areYouSure') }}",
            text: "{{ trans('global.canNotRevert') }}",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger m-l-10',
            confirmButtonText: "{{ trans('global.yesDelete') }}"
        }).then((result) => {
            if (result.value) {
                $(form).submit();
            } else
            {
                return false;
            }
        });
    }

    let changeLang = (str) => {
        if(str === "{{ session('cur_lang') }}") return;

        $.post("{{ url('change_lang') }}", {lang: str}, function () {

        })
            .done(function() {
                location.reload();
            })
            .fail(function(res) {

            });
    }

    let formatDate = (date) => {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }

</script>