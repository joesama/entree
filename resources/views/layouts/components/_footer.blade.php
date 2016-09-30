<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="{{ asset('packages/threef/entree/js/application.min.js') }}"></script>
<script type="text/javascript">
$("select").select2({
  tags: "true",
  placeholder: {
    id: '-1', // the value of the option
    text: 'Select an option'
  },
  allowClear: true
});
</script>