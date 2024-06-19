@extends('layout.master')
@section('main-content')
<section class="main-tabs">
    <div id="tabs" class="container"> 
        <ul class="nav nav-tabs">
            <li>
                <a href="#1" data-toggle="tab" class="active"><i class="fa fa-file-lines"></i> Text</a>
            </li>
            <li>
                <a href="#2" data-toggle="tab"><i class="fa fa-copy"></i> Files</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="1">
                <textarea id="text" name="text" class="form-control text-input" placeholder="Type Something..."></textarea>
                <div class="row btn-row">
                    <div class="col-12">
                        <button id="btn-clear" class="btn-clear d-none">Clear</button>
                        <button id="btn-save-text" disabled class="btn-save-text">Save</button>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="2">
                <div class="drag-drop-wrap no-file">
                    <div class="no-file-upload-wrap">
                        <h4>Drag and drop any files up to 2 files, 5Mbs each or <a href="#" id="browse">Browse</a><br></h4>
                        <h4><a href="#">Upgrade</a> to get more space</h4>
                    </div>
                    <div class="files-wrap d-none">
                        <div class="add-new-file">
                            <p class="add-file"><i class="fas fa-plus"></i><br>Add File</p>
                            <p class="up-to">( up to 5Mb )</p>
                        </div>
                    </div>
                </div>
                <input type="file" class="d-none" id="file-input" multiple>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
</script>
@endsection