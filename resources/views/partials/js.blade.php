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
    function isConfirm(form)
    {
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
</script>