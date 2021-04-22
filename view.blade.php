<div class="modal fade popups hint_brand" id="hint_brand{{$d->id}}" >
  <div class="modal-dialog">
    <div class="modal-content clearfix">
      <a href="javascript:void(0)" class="remove-modal">x</a>
      <div class="modal-body clearfix">
        <ul id="media-list" class="clearfix">
        </ul>
      </div>
      <button type="button" id="media-send{{$d->id}}" class="send media-s"></button>
    </div>
  </div>
</div>
<div class="typezone">
  <form class="chat-form">
    <label class="file"><i class="fa fa-paperclip"></i>
      <input type="file" class="picupload{{$d->id}}" id="attechment_id{{$d->id}}" click-type="type1"  multiple>
    </label>
    <input type="hidden" id="project_id{{$d->id}}" value="{{$d->id}}">
    <input type="hidden" id="sender_id{{$d->id}}" value="{{Auth::user()->id}}">
    <textarea type="text" id="message{{$d->id}}" placeholder="Say something"></textarea>
    <button type="button" id="chat-send{{$d->id}}" class="send"></button>
  </form>
</div>

<script>
$(function () {
        var names = [];
        $(document).on("change", ".picupload{{$d->id}}", function (event) {
            var getAttr = $(this).attr("click-type");
            var files = event.target.files;
            var output = document.getElementById("media-list");
            var z = 0;
            if (getAttr == "type1") {
                $("#media-list").html("");
                $("#media-list").html('<li class="myupload"><span><i class="fa fa-plus" aria-hidden="true"></i><input type="file" click-type="type2" class="picupload{{$d->id}}" multiple></span></li>');
                $("#hint_brand{{$d->id}}").modal("show");

                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    names.push($(this).get(0).files[i]);

                    var picReader = new FileReader();
                    picReader.fileName = file.name;

                    var validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];

                    if ($.inArray(file.type, validImageTypes) !== -1 ) {
						picReader.addEventListener("load", function (event) {
                        var picFile = event.target;

                        var div = document.createElement("li");

                        div.innerHTML =
                            "<img src='" +
                            picFile.result +
                            "'" +
                            "title='" +
                            event.target.fileName +
                            "'/><div  class='post-thumb'><div class='inner-post-thumb'><a href='javascript:void(0);' data-id='" +
                            event.target.fileName +
                            "' class='remove-pic'><i class='fa fa-times' aria-hidden='true'></i></a><div></div>";
                        $("#media-list").prepend(div);
                    });
					} else {
					picReader.addEventListener("load", function (event) {
                        var picFile = event.target;

                        var div = document.createElement("li");

                        div.innerHTML =
                            "<div class='notimage'><i class='fa fa-file'></i><p>"+ event.target.fileName +"</p></div><div  class='post-thumb'><div class='inner-post-thumb'><a href='javascript:void(0);' data-id='" +
                            event.target.fileName +
                            "' class='remove-pic'><i class='fa fa-times' aria-hidden='true'></i></a><div></div>";
                        $("#media-list").prepend(div);
                    });
					}                   

                    picReader.readAsDataURL(file);
                }
            } else if (getAttr == "type2") {
                $("#hint_brand{{$d->id}}").modal("show");
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    names.push($(this).get(0).files[i]);

                    var picReader = new FileReader();
                    picReader.fileName = file.name;

                    var validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];

                    if ($.inArray(file.type, validImageTypes) !== -1 ) {
						picReader.addEventListener("load", function (event) {
                        var picFile = event.target;

                        var div = document.createElement("li");

                        div.innerHTML =
                            "<img src='" +
                            picFile.result +
                            "'" +
                            "title='" +
                            event.target.fileName +
                            "'/><div  class='post-thumb'><div class='inner-post-thumb'><a href='javascript:void(0);' data-id='" +
                            event.target.fileName +
                            "' class='remove-pic'><i class='fa fa-times' aria-hidden='true'></i></a><div></div>";
                        $("#media-list").prepend(div);
                    });
					} else {
					picReader.addEventListener("load", function (event) {
                        var picFile = event.target;

                        var div = document.createElement("li");

                        div.innerHTML =
                            "<div class='notimage'><i class='fa fa-file'></i><p>"+ event.target.fileName +"</p></div><div  class='post-thumb'><div class='inner-post-thumb'><a href='javascript:void(0);' data-id='" +
                            event.target.fileName +
                            "' class='remove-pic'><i class='fa fa-times' aria-hidden='true'></i></a><div></div>";
                        $("#media-list").prepend(div);
                    });
					}                 

                    picReader.readAsDataURL(file);
                }
                // return array of file name
            }

            $(document).on("click", ".remove-pic", function () {
                $(this).parent().parent().parent().remove();
                var removeItem = $(this).attr("data-id");

                for (var i = 0; i < names.length; i++) {
                    if (names[i].name === removeItem) {
                        names.splice(i, 1);
                        break;
                    }
                }

                if (names.length == 0) {
                    $("#hint_brand{{$d->id}}").modal("hide");
                    $("#media-list").html("");
                } else {
                    $("#hint_brand{{$d->id}}").modal("show");
                }
                // return array of file name
            });
        });

        $(document).on("click", ".remove-modal", function () {
            $("#hint_brand{{$d->id}}").modal("hide");
            $("#media-list").html("");
            names = [];
            z = 0;
            $(".picupload{{$d->id}}").val("");
            // console.log(names);
        });
        $("#hint_brand{{$d->id}}").on("hidden.bs.modal", function (e) {
            names = [];
            z = 0;
        });

        $(document).on("click", "#media-send{{$d->id}}", function (e) {
            e.preventDefault();
            var project_id = $("#project_id{{$d->id}}").val(),
                sender_id = $("#sender_id{{$d->id}}").val();
            var image_upload = new FormData();
            var TotalImages = names.length; //Total Images
            for (var i = 0; i < TotalImages; i++) {
                image_upload.append("images" + i, names[i]);
            }
            image_upload.append("TotalImages", TotalImages);
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
            });

            $.ajax({
                type: "POST",
                url: "/admin/send_media/" + project_id + "_" + sender_id,
                contentType: false,
                processData: false,
                data: image_upload,
                success: function (data) {
                    $("#message{{$d->id}}").val("");
                    $("#hint_brand{{$d->id}}").modal("hide");
                    $("#media-send{{$d->id}}").hide();
                    names = [];
                    z = 0;
                    $(".chat").html();
                    $(".chat").html(data);
                    $(".chat")
                        .stop()
                        .animate({ scrollTop: $(".chat")[0].scrollHeight }, 1000);
                },
            });
        });
    });

</script>
