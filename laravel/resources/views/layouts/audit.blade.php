<!doctype html>
<html>
<head>
    @include('includes.head')
    {!! Html::style('assets/metronic/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css') !!}
    {!! Html::style('assets/metronic/global/plugins/bootstrap-wysihtml5/wysiwyg-color.css') !!}
    {!! Html::style('assets/metronic/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css') !!}
    {!! Html::style('assets/metronic/global/plugins/bootstrap-summernote/summernote.css') !!}
    {!! Html::style('assets/metronic/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') !!}

</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo">
	@include('includes.header')
	@include('includes.sidebar')
	@yield('content')
	@include('includes.footer')
	{!! Html::script('assets/metronic/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js') !!}
	{!! Html::script('assets/metronic/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js') !!}
	{!! Html::script('assets/metronic/global/plugins/bootstrap-markdown/lib/markdown.js') !!}
	{!! Html::script('assets/metronic/global/plugins/bootstrap-markdown/js/bootstrap-markdown.js') !!}
	{!! Html::script('assets/metronic/global/plugins/bootstrap-summernote/summernote.js') !!}
	{!! Html::script('assets/metronic/admin/pages/scripts/components-editors.js') !!}
	{!! Html::script('assets/metronic/admin/pages/scripts/components.js')!!}
</body>
</html>