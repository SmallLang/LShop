@extends('admin.layouts.app')

@section('title', '管理中心')
@section('pageHeader', '商品分类管理')
@section('pageAction')
    <button type="button" class="btn btn-success" onclick="location.href='{{ url('admin/category/create') }}'">添加商品分类</button>
@endsection
@section('HeaderCSSAndJS')
    <meta name="_token" content="{{ csrf_token() }}">
    <script src="//cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link href="//cdn.bootcss.com/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div  class="panel-heading">
                    商品分类列表
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>商品分类名称</th>
                                <th>上级分类</th>
                                <th>创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ str_repeat('----', $category->depth - 1) . $category->name }}</td>
                                    <td>{{ $category->parent->name }}</td>
                                    <td>{{ $category->created_at }}</td>
                                    <td><a href="{{ url('admin/category/' . $category->id . '/edit') }}">编辑</a> |
                                        <a href="#">移除</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $categories->links() }}
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    @include('sweet::alert')
@endsection