@extends('pages.dashboard.dash_main')

@section('content')
<section id="main-content">
    <section class="wrapper">
        <div style="padding:8px">
            <div class="row mt">
                @if($event == null)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Create Event</h4>
                    </div>
                    <div class="panel-body">
                        <form autocomplete="off" enctype="multipart/form-data" action="{{ route('devent.store') }}" method="post">
                            {{ csrf_field()}}
                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label for="name">Name</label>
                                </div>
                                <div class="col-lg-8">
                                    <input id="name" value="{{old('name')}}" name="name" class="form-control" type="text" />
                                    @error('name')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label for="details">Details</label>
                                </div>
                                <div class="col-lg-8">
                                    <textarea id="summernote" name="details" class="form-control">{{old('details')}}</textarea>
                                    @error('details')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label for="venue">Venue</label>
                                </div>
                                <div class="col-lg-8">
                                    <input id="venue" name="venue" class="form-control" type="text" />
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label for="date">Date</label>
                                </div>
                                <div class="col-lg-2 col-xs-6">
                                    <div data-date-viewmode="years" data-date-format="yyyy-mm-dd" data-date="2020-01-01" class="input-append date dpYears">
                                        <input type="text" readonly name="date" class="form-control" />
                                        <span class="input-group-btn add-on">
                                            <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label for="name">Time</label>
                                </div>
                                <div class="col-lg-2 col-xs-6">
                                    <div class="input-group bootstrap-timepicker">
                                        <input type="text" readonly name="time" class="form-control timepicker-24" />
                                        <span class="input-group-btn add-on">
                                            <button class="btn btn-theme" type="button"><i class="fa fa-clock-o"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group" style="margin-top: 30px">
                                <div class="col-lg-2">
                                    <label for="content">Upload Cover Image</label>
                                </div>
                                <div class="col-lg-8">
                                    <input name="coverImage" type="file" class="form-control-file" />
                                </div>
                            </div>
                            <div class="row form-group pull-right" style="margin-right: 5px">
                                <button type="submit" class="btn btn-theme03">
                                    Add Event
                                </button>
                                <a href="/devents" class="btn btn-default">
                                    <i class="fa fa-list"></i>
                                    To List
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                @else

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Edit Event</h4>
                    </div>
                    <div class="panel-body">
                        <form autocomplete="off" enctype="multipart/form-data" action="{{ route('devent.update', $event->id) }}" method="post">
                            {{ csrf_field()}}
                            @method('put')
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="row form-group">
                                        <div class="col-lg-2">
                                            <label for="name">Name</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input id="name" name="name" value="{{old('name') ? old('name') : $event->name}}" class="form-control" type="text" />
                                            @error('name')
                                            <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-2">
                                            <label for="details">Details</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <textarea id="summernote" name="details" class="form-control">{{old('details') ? old('details') : $event->details}}</textarea>
                                            @error('details')
                                            <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-2">
                                            <label for="venue">Venue</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input id="venue" name="venue" value="{{$event->venue}}" class="form-control" type="text" />
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-2">
                                            <label for="date">Date</label>
                                        </div>
                                        <div class="col-lg-2 col-xs-6">
                                            <div data-date-viewmode="years" data-date-format="yyyy-mm-dd" data-date="2020-01-01" class="input-append date dpYears">
                                                <input type="text" value="{{$event->date}}" readonly name="date" class="form-control" />
                                                <span class="input-group-btn add-on">
                                                    <button class="btn btn-theme" type="button"><i class="fa fa-calendar"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row form-group">
                                        <div class="col-lg-2">
                                            <label for="name">Time</label>
                                        </div>
                                        <div class="col-lg-2 col-xs-6">
                                            <div class="input-group bootstrap-timepicker">
                                                <input type="text" readonly value="{{$event->time}}" name="time" class="form-control timepicker-24" />
                                                <span class="input-group-btn add-on">
                                                    <button class="btn btn-theme" type="button"><i class="fa fa-clock-o"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group" style="margin-top: 30px">
                                        <div class="col-lg-2">
                                            <label for="content">Upload Cover Image</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input name="coverImage" type="file" class="form-control-file" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <img src="{{asset('storage/'. $event->coverImage)}}" width="100%" style="border-radius:4px;border:1px solid #bbb9b9;margin-bottom: 5px" />
                                </div>
                            </div>
                            <div class="row form-group pull-right" style="margin-right: 5px">
                                <button type="submit" class="btn btn-theme03">
                                    Update Event
                                </button>
                                <a href="/devents" class="btn btn-default">
                                    <i class="fa fa-list"></i>
                                    To List
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 300
        })
    });
</script>
<script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
<script src="{{asset('lib/bootstrap/js/bootstrap.min.js')}}"></script>
<script class="include" type="text/javascript" src="{{asset('lib/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('lib/jquery.scrollTo.min.js')}}"></script>
<script src="{{asset('lib/jquery.nicescroll.js')}}" type="text/javascript"></script>
<script src="{{asset('lib/jquery-ui-1.9.2.custom.min.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{asset('lib/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script>

<script type="text/javascript" src="{{asset('lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>

<!--common script for all pages-->
<script src="{{asset('lib/common-scripts.js')}}"></script>
<script src="{{asset('lib/advanced-form-components.js')}}"></script>
@endsection
