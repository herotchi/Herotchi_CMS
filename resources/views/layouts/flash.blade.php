{{--成功時--}}
@if (session('msg_success')) 
<script>
	$(function () {
		toastr.success(`{{ session('msg_success') }}`);
	});
</script>
@endif

{{--失敗時--}}
@if (session('msg_failure'))
<script>
    $(function () {
		toastr.error(`{{ session('msg_failure') }}`);
	});
</script>
@endif
