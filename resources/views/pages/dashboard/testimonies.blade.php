@extends('pages.dashboard.dash_main')

@section('content')

<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-md-12">
                <div class="content-panel">
                    <div class="pull-right">
                        <label>Search: <input type="text" placeholder="by username..."></label>
                    </div>
                  
                    <table class="table table-striped table-advance table-hover">
                        <h4><i class="fa fa-angle-right"></i> All Testimonies</h4>
                        <hr>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th><i class="fa fa-user"></i>Posted by</th>
                                <th><i class="fa fa-edit"></i> Status</th>
                                <th><i class="fa fa-clock-o"></i> Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($data->data != null)
                            @for($i=0; $i < count($data->data); $i++)
                                <tr>
                                    <td>
                                        {{$data->from + $i}}
                                    </td>
                                    <td>{{$data->data[$i]->user->name}}</td>
                                    @if (($data->total - ($data->from + $i)) < 15) 
                                        <td><span class="label label-success label-mini">active!!!!</span></td>
                                    @else
                                        <td><span class="label label-default label-mini">passive!!</span></td>
                                    @endif
                                        <td>{{date('M', strtotime($data->data[$i]->created_at))}} {{date('d', strtotime($data->data[$i]->created_at)) }}, {{ date('yy', strtotime($data->data[$i]->created_at)) }}</td>
                                        <td>
                                            <form method="post" action="{{ route('testimonies.destroy', $data->data[$i]->id) }}">
                                                {{ csrf_field() }}
                                                @method('delete')
                                                <button data-des="{{$data->from + $i}} from {{$data->data[$i]->user->name}}" data-content="{{$data->data[$i]->content}}" type="button" data-toggle="modal" data-target="#viewTestimony" class="open-viewTestimony btn btn-success btn-xs"><i class="fa fa-check-square-o"></i></button>
                                                <button type="submit" class="btn btn-danger btn-xs">
                                                    <i class="fa fa-trash-o "></i>
                                                </button>
                                            </form>
                                        </td>
                                </tr>
                                @endfor
                                @endif

                        </tbody>
                    </table>
                    @if($data->last_page != 1)
                    <div class="row-fluid">
                        <div class="dataTables_info">Showing {{$data->from}} to {{$data->to}} of {{$data->total}} entries</div>
                        <div class="dataTables_paginate paging_bootstrap pagination">
                            <ul>
                                <li class="prev {{$data->prev_page_url == null ? 'disabled' : ''}}"><a href="{{url('testimonies/'. Crypt::encrypt($data->current_page - 1))}}">← Previous</a></li>
                                @for($i=1; $i <= $data->last_page; $i++)
                                    <li class="{{ $data->current_page == $i ? 'active' : '' }}"><a href="{{url('testimonies/'. Crypt::encrypt($i))}}">{{$i}}</a></li>
                                    @endfor
                                    <li class="next {{$data->next_page_url == null ? 'disabled' : ''}}"><a href="{{url('testimonies/'.Crypt::encrypt($data->current_page + 1))}}">Next → </a></li>
                            </ul>
                        </div>
                    </div>
                    @endif

                    <div aria-hidden="true" aria-labelledby="TestimonyModal" role="dialog" tabindex="-1" id="viewTestimony" class="modal fade">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"></h5>
                                </div>
                                <div class="modal-body">
                                    <p id="request_content"></p>
                                </div>
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
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

<script>
    $(document).on("click", ".open-viewTestimony", function() {
        var requestcontent = $(this).data('content');
        var des = $(this).data('des');

        $(".modal-body #request_content").text(requestcontent);
        $(".modal-title").text("Testimony " + des);
    })
</script>
@endsection