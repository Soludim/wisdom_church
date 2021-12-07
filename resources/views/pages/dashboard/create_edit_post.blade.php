@extends('pages.dashboard.dash_main')

@section('content')
<section id="main-content">
  <section class="wrapper">
    <div style="padding:8px">
      <div class="row mt">
        @if($data == null)
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4>Create your post</h4>
          </div>
          <div class="panel-body">
            <form action="{{route('post.store')}}" method="post" autocomplete="off" enctype="multipart/form-data">
              @csrf
              <div class="form-group">
                <label for="title">Title</label>
                <input id="title" value="{{old('title')}}" name="title" class="form-control" type="text" />
                @error('title')
                <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
              <div class="form-group">
                <label for="title">Content</label>
                <textarea id="summernote" name="content" class="form-control">{!!old('content')!!}</textarea>
                @error('content')
                <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
              <div class="form-group">
                <label for="category">Category</label>
                <select class="form-control" name="category">
                  @foreach($categories as $category)
                  <option  {{$category->id == old('category') ? 'selected' : ''}} value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach
                </select>
                @error('category')
                <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
              <div class="form-group" style="margin-top: 30px">
                <label for="coverImage">Upload Cover Image</label>
                <input name="coverImage" type="file" class="form-control-file" />
                @error('coverImage')
                <p class="text-danger">{{ $message }}</p>
                @enderror
              </div>
              <div class="form-group pull-right">
                <button type="submit" class="btn btn-theme03">
                  <i class="fa fa-check"></i>
                  POST
                </button>
              </div>
            </form>
          </div>
        </div>
        @else
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4>Edit Post</h4>
          </div>
          <div class="panel-body">
            <form action="{{ route('post.update', Crypt::encrypt($data->id)) }}" method="post" autocomplete="off" enctype="multipart/form-data">
              @csrf
              @method('put')
              <div class="row">
                <div class="col-lg-10">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input value="{{old('title') ? old('title') : $data->title}}" name="title" class="form-control" type="text" />
                    @error('title')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="title">Content</label>
                    <textarea id="summernote" name="content" class="form-control">{!! old('content') ? old('content') : $data->content!!}</textarea>
                    @error('content')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" name="category">
                      @foreach($categories as $category)
                      <option {{$category->id == $data->category_id ? 'selected' : ''}} value="{{$category->id}}">{{$category->name}}</option>
                      @endforeach
                    </select>
                    @error('category')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group" style="margin-top: 30px">
                    <label for="coverImage">Update Cover Image</label>
                    <input name="coverImage" type="file" class="form-control-file" />
                    @error('coverImage')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-2">
                  <img src="{{asset('storage/'. $data->coverImage)}}" width="100%" style="border-radius:4px;border:1px solid #bbb9b9;margin-bottom: 5px" />
                </div>
              </div>
              <div class="form-group pull-right">
                <button type="submit" class="btn btn-theme03">
                  <i class="fa fa-check"></i>
                  UPDATE
                </button>
              </div>
            </form>
          </div>
        </div>
        @endif
      </div>
    </div>
  </section>
</section>


<script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
<script src="{{asset('lib/bootstrap/js/bootstrap.min.js')}}"></script>
<script class="include" type="text/javascript" src="{{asset('lib/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('lib/jquery.scrollTo.min.js')}}"></script>
<script src="{{asset('lib/jquery.nicescroll.js')}}" type="text/javascript"></script>
<!--common script for all pages-->
<script src="{{asset('lib/common-scripts.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#summernote').summernote({
      height: 300
    })
  });
</script>
@endsection