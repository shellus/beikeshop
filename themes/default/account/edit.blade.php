@extends('layout.master')

@section('body-class', 'page-account-edit')

@push('header')
  {{-- <script src="{{ asset('vendor/vue/2.6.14/vue.js') }}"></script> --}}
  <script src="{{ asset('vendor/cropper/cropper.min.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('vendor/cropper/cropper.min.css') }}">
@endpush

@section('content')
  <div class="container" id="address-app">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Library</li>
      </ol>
    </nav>

    <div class="row">
      <x-shop-sidebar/>

      <div class="col-12 col-md-9">
        <div class="card h-min-600">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">修改个人信息</h5>
          </div>
          <div class="card-body h-600">
            <form>
              <div class="bg-light rounded-3 p-4 mb-4" style="background: #f6f9fc;">
                <div class="d-flex align-items-center">
                  <img class="rounded-3" id="avatar" src="{{ image_resize($customer->avatar, 200, 200) }}" width="90">
                  <div class="ps-3">
                    <label class="btn btn-light shadow-sm bg-body mb-2" data-toggle="tooltip" title="Change your avatar">
                      <i class="bi bi-arrow-repeat"></i> 修改头像
                      <input type="file" class="d-none" id="update-btn" name="avatar" accept="image/*">
                    </label>
                    <div class="p mb-0 fs-ms text-muted">上传JPG、GIF或PNG图片。需要300 x 300。</div>
                  </div>
                </div>
              </div>
              <div class="row gx-4 gy-3">
                <div class="col-sm-6">
                  <label class="form-label">名称</label>
                  <input class="form-control" type="text" name="name" value="{{ $customer->name }}">
                </div>
                <div class="col-sm-6">
                  <label class="form-label">邮箱</label>
                  <input class="form-control" type="email" name="email" value="{{ $customer->email }}">
                </div>
                <div class="col-sm-6">
                  <label class="form-label">密码</label>
                  <input class="form-control" type="password" placeholder="留空则保持原密码不变" name="password" value="">
                </div>
                <div class="col-12 mt-4">
                  <button class="btn btn-primary mt-sm-0" type="button">提交</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

    <div class="modal fade" id="modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">裁剪</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="img-container">
              <img id="cropper-image" src="{{ image_resize('/') }}" class="img-fluid">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
            <button type="button" class="btn btn-primary cropper-crop">确定</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('add-scripts')
  <script>
    var avatar = document.getElementById('avatar');
    var image = document.getElementById('cropper-image');
    var cropper;
    var $modal = $('#modal');

    $('#update-btn').change(function(e) {
      var files = e.target.files;
      var done = function (url) {
        $(this).val('');
        // $('#c-image').prop('src', url);
        image.src = url;
        $('#modal').modal('show');
      };

      var reader;
      var file;
      var url;

      if (files && files.length > 0) {
        file = files[0];

        if (URL) {
          done(URL.createObjectURL(file));
        } else if (FileReader) {
          reader = new FileReader();
          reader.onload = function (e) {
            done(reader.result);
          };
          reader.readAsDataURL(file);
        }
      }
    });

    $modal.on('shown.bs.modal', function () {
      cropper = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 3,
      });
    }).on('hidden.bs.modal', function () {
      cropper.destroy();
      cropper = null;
    });

    $('.cropper-crop').click(function(event) {
      var initialAvatarURL;
      var canvas;

      $modal.modal('hide');

      if (cropper) {
        canvas = cropper.getCroppedCanvas({
          width: 200,
          height: 200,
        });
        initialAvatarURL = avatar.src;
        avatar.src = canvas.toDataURL();
        canvas.toBlob(function (blob) {
          var formData = new FormData();

          formData.append('avatar', blob, 'avatar.png');
          console.log(formData)
        });
      }
    });
  </script>
@endpush