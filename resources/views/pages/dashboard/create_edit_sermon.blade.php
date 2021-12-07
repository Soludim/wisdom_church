@extends('pages.dashboard.dash_main')

@section('content')
<section id="main-content">
    <section class="wrapper">
        <div style="padding:8px">
            <div class="row mt">
                @if($sermon == null)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Create Sermon</h4>
                    </div>
                    <div class="panel-body">
                        <form id="sermon_create_edit" action="{{route('dsermon.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label for="topic">Topic</label>
                                </div>
                                <div class="col-lg-10">
                                    <input id="topic" value="{{old('topic')}}" name="topic" class="form-control" type="text" />
                                    @error('topic')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label for="content">Content</label>
                                </div>
                                <div class="col-lg-10">
                                    <textarea id="summernote" name="content" class="form-control">{!!old('content')!!}</textarea>
                                    @error('content')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-lg-2">
                                    <label for="content">Speaker</label>
                                </div>
                                <div class="col-lg-3">
                                    <input type="text" id="speaker_name" value="{{old('speaker_name')}}" placeholder="speaker name" name="speaker_name" class="form-control" />
                                    @error('speaker_name')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="col-lg-3">
                                    <input type="text" id="speaker_position" value="{{old('speaker_position')}}" disabled placeholder="speaker position" name="speaker_position" class="form-control" />
                                    @error('speaker_position')
                                    <p class="text-danger">{{$message}}</p>
                                    @enderror
                                </div>
                                <input type="text" hidden name="user_image" id="user_image" /> <!-- Speaker's image url when he is already a user -->
                                <div class="col-lg-3">
                                    <input id="image" disabled type="file" name="speaker_image" class="form-control" />
                                </div>
                                <div class="col-lg-1 col-md-4 col-sm-4 col-xs-12">
                                    <img id="speakerImage" src="" width="100%" style="border-radius:4px;border:1px solid #bbb9b9;margin-bottom: 5px" />
                                </div>
                            </div>
                            <div class="row form-group" style="margin-top: 30px">
                                <div class="col-lg-2">
                                    <label for="content">Video url</label>
                                </div>
                                <div class="col-lg-10">
                                    <input name="video_url" placeholder="if any..." type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="row form-group" style="margin-top: 30px">
                                <div class="col-lg-2">
                                    <label for="content">Upload Cover Image</label>
                                </div>
                                <div class="col-lg-10">
                                    <input name="coverImage" type="file" class="form-control-file" />
                                </div>
                            </div>
                            <div class="row form-group pull-right" style="margin-right: 5px">
                                <button type="submit" class="btn btn-theme03">
                                    Create
                                </button>
                                <a href="/dsermons" class="btn btn-default">
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
                        <h4>Edit Sermon</h4>
                    </div>
                    <div class="panel-body">
                        <form id="sermon_create_edit" action="{{route('dsermon.update', Crypt::encrypt($sermon->id))}}" method="post" autocomplete="off" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                                <div class="col-lg-10">
                                    <div class="row form-group">
                                        <div class="col-lg-2">
                                            <label for="topic">Topic</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input id="topic" value="{{old('topic') ? old('topic') : $sermon->topic}}" name="topic" class="form-control" type="text" />
                                            @error('topic')
                                            <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-2">
                                            <label for="content">Content</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <textarea id="summernote" name="content" class="form-control">{!!old('content') ? old('content') :$sermon->content !!}</textarea>
                                            @error('content')
                                            <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-lg-2">
                                            <label for="content">Speaker</label>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" id="speaker_name" value="{{old('speaker_name') ? old('speaker_name') : $sermon->speaker_name}}" placeholder="speaker name" name="speaker_name" class="form-control" />
                                            @error('speaker_name')
                                            <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" id="speaker_position" value="{{old('speaker_position') ? old('speaker_position') : $sermon->speaker_position}}" disabled placeholder="speaker position" name="speaker_position" class="form-control" />
                                            @error('speaker_position')
                                            <p class="text-danger">{{$message}}</p>
                                            @enderror
                                        </div>
                                        <input type="text" hidden name="user_image" id="user_image" /> <!-- Speaker's image url when he is already a user -->
                                        <div class="col-lg-3">
                                            <input id="image" disabled type="file" name="speaker_image" class="form-control" />
                                        </div>
                                        <div class="col-lg-1 col-xs-3">
                                            <img id="speakerImage" src="{{asset('storage/'. $sermon->speaker_image)}}" width="100%" style="border-radius:4px;border:1px solid #bbb9b9;margin-bottom: 5px" />
                                        </div>
                                    </div>
                                    <div class="row form-group" style="margin-top: 30px">
                                        <div class="col-lg-2">
                                            <label for="content">Video url</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input name="video_url" type="text" value="{{$sermon->video_url}}" class="form-control" />
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
                                    <img src="{{asset('storage/'. $sermon->coverImage)}}" width="100%" style="border-radius:4px;border:1px solid #bbb9b9;margin-bottom: 5px" />
                                </div>
                            </div>
                            <div class="row form-group pull-right" style="margin-right: 5px">
                                <button type="submit" class="btn btn-theme03">
                                    Edit Sermon
                                </button>
                                <a href="/dsermons" class="btn btn-default">
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
<!--common script for all pages-->
<script src="{{asset('lib/common-scripts.js')}}"></script>

<script src="{{asset('lib/advanced-form-components.js')}}"></script>

<script>
    function autocomplete(inp, arr) {

        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener('input', function(e) {
            var a, b, i, val = this.value;
            var count = 0; //number of resulted from the sort
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) {
                return false;
            }
            document.getElementById('speaker_position').setAttribute('disabled', 'true');
            document.getElementById('speaker_position').value = '';
            document.getElementById('user_image').value = ''
            document.getElementById('image').setAttribute('disabled', 'true');
            document.getElementById('speakerImage').setAttribute('src', '');
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                if (arr[i].name.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    ++count; // increase item count
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    /*make the matching letters bold:*/
                    b.innerHTML = "<strong>" + arr[i].name.substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].name.substr(val.length);
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input id='" + i + "' type='hidden' value='" + arr[i].name + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function(e) {
                        let speaker = arr[this.getElementsByTagName("input")[0].id];
                        document.getElementById('speaker_position').value = speaker.role.name;
                        document.getElementById('speakerImage').setAttribute("src", `{{asset('storage/${speaker.profile_pic}')}}`)
                        document.getElementById('user_image').value = speaker.profile_pic;
                        /*insert the value for the autocomplete text field:*/
                        console.log(this.getElementsByTagName("input")[0].id)
                        inp.value = this.getElementsByTagName("input")[0].value;
                        /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                        closeAllLists();
                    });
                    a.appendChild(b);
                } else {
                    if (i == arr.length - 1 && count == 0) {
                        document.getElementById('speaker_position').removeAttribute('disabled');
                        document.getElementById('image').removeAttribute('disabled');
                        document.getElementById('speakerImage').setAttribute('src', '');
                    }
                }
            }

            count = 0; //initialize count back to zero
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
        });

        function addActive(x) {
            /*a function to classify an item as "active":*/
            if (!x) return false;
            /*start by removing the "active" class on all items:*/
            removeActive(x);
            if (currentFocus >= x.length) currentFocus = 0;
            if (currentFocus < 0) currentFocus = (x.length - 1);
            /*add class "autocomplete-active":*/
            x[currentFocus].classList.add("autocomplete-active");
        }

        function removeActive(x) {
            /*a function to remove the "active" class from all autocomplete items:*/
            for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
            }
        }

        function closeAllLists(elmnt) {
            /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
            var x = document.getElementsByClassName("autocomplete-items");
            for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                    x[i].parentNode.removeChild(x[i]);
                }
            }
        }
        /*execute a function when someone clicks in the document:*/
        document.addEventListener("click", function(e) {
            closeAllLists(e.target);
        });
    }

    var SystemUsers = @json($systemUsers);

    autocomplete(document.getElementById("speaker_name"), SystemUsers);

    $('#sermon_create_edit').submit(function(e) {
        $(':disabled').each(function(e) {
            $(this).removeAttr('disabled')
        })
    })
</script>
@endsection
