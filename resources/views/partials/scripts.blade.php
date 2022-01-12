<script src="{{ asset('assets/js/plugin.bundle.min.js')}}"></script>
<script src="{{ asset('ssets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('assets/api/jqueryvalidate/jquery.validate.min.js')}}"></script>
<script src="{{ asset('assets/js/script.bundle.js')}}"></script>
<script>
	var options = {
        debug: 'info',
        modules: {
            toolbar: '#toolbar'
        },
        placeholder: 'Compose an epic...',
        readOnly: true,
        theme: 'snow'
    };
var editor = new Quill('#editor', options);

jQuery(document).ready( function () {
	jQuery('#myTable').DataTable();
} );
</script>
