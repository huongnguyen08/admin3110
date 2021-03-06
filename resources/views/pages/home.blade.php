@extends('layout2') @section('title', 'Home - Danh sách sản phẩm') @section('content')
<div class="panel panel-body">
    <section class="content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>Danh sách sản phẩm</b>
            </div>
            <div class="panel-body">
                @if(Session::has('success'))
                    <div class="alert alert-success">
                    {{Session::get('success')}}
                    </div>
                @endif
                @if(Session::has('error'))
                    <div class="alert alert-danger">
                    {{Session::get('error')}}
                    </div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên sp</th>
                            <th>Tên loại </th>
                            <th>Đơn giá</th>
                            <th>Hình</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $stt = 1;?>
                        @foreach($foods as $f)
                        <tr id="food-{{$f->id}}">
                            <td>{{$stt++}}</td>
                            <td>{{$f->name}}</td>
                            <td>{{$f->foodType->name}}</td>
                            <td>{{number_format($f->price)}}</td>
                            <td>
                            <img src="source/img/hinh_mon_an/{{$f->image}}" height="100px">
                            </td>

                            <td>
                                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'editor' )
                                <a href="{{route('get_edit',['id'=>$f->id, 'alias'=>$f->pageUrl->url])}}"><i class="fa fa-edit fa-2x"></i></a> |
                                @endif
                                @if(Auth::user()->role == 'admin' )
                                
                                <a class="delete-food" data-name="{{$f->name}}" data-id="{{$f->id}}" data-alias="{{$f->pageUrl->url}}">
                                    <i class="fa fa-trash-o fa-2x" aria-hidden="true"></i>
                                </a>
                                @endif
                            </td>

                        </tr>
                        @endforeach
                        </tbody>
                </table>
                {{$foods->links()}}
            </div>
        </div>
    </section>
</div>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
        <p>Bạn có chắc chắn xoá <b class="name-food">...</b> hay không?</p>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-success btn-Accept" >
        <a id="link-remove" >Ok</a>
        </button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<script src="source/js/jquery.js"></script>
<script>
$(document).ready(function(){
    $('.delete-food').click(function(){
        
        //reset modal
        $('.btn-Accept').show()
        $('.modal-body').html('<p>Bạn có chắc chắn xoá <b class="name-food">...</b> hay không?</p>')

        var id = $(this).attr('data-id');
        var alias = $(this).attr('data-alias');
        var name = $(this).attr('data-name');

        var route = "{{route('delete',['id', 'alias'])}}";
        route = route.replace('id',id)
        route = route.replace('alias',alias)
        //console.log(route)

        $('.name-food').html(name)
        //$('#link-remove').attr('href',route)

        $('#myModal').modal('show')


        $('#myModal').on('hidden.bs.modal', function (e) {
            id =name = alias = ''
        })
        
        $('.btn-Accept').click(function(){
            if(id != '' && alias!= ''){
                $.ajax({
                    type: "GET",
                    url: route  ,
                    success:function(data){
                        console.log(data)
                        if($.trim(data)!="error"){
                            $('.modal-body').html('Xoá thành công')
                            $('.btn-Accept').hide()
                            $('#food-'+id).hide()
                        }
                        else{
                            $('.modal-body').html('Xoá thất bại')
                            $('.btn-Accept').hide()
                        }
                    }
                })
            }
        })
    })
    
        
})
</script>
@endsection