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
                <textarea id="text" name="text" class="form-control text-input" placeholder="Type Something...">{{ $text }}</textarea>
                <div class="row btn-row">
                    <div class="col-12">
                        <button id="btn-clear" class="btn-clear {{ (!$text) ? 'd-none' : '' }}">Clear</button>
                        <button id="btn-save-text" action="{{ ($text) ? 'copy' : 'save' }}" @disabled(!$text) data-url="{{ route('save.text') }}" class="btn-save-text">{{ ($text) ? 'Copy' : 'Save' }}</button>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="2">
                <div @class([ 'drag-drop-wrap', 'no-file' => $files->isEmpty() ])>
                    <div @class([ 'no-file-upload-wrap', 'd-none' => !$files->isEmpty() ])>
                        <h4>Drag and drop any files up to 10 files, 5Mbs each or <a href="#" id="browse">Browse</a><br></h4>
                        <h4><a href="#">Upgrade</a> to get more space</h4>
                    </div>
                    <div @class([ 'row', 'btn-files-row', 'd-none' => $files->isEmpty() ])>
                        <div class="col-md-12 text-right btn-files-wrap">
                            <form action="{{ route('file.download.all') }}" name="form_download_all_files" method="POST" target="_blank">
                                @csrf
                                <button class="btn-transparent" type="submit"><i class="fas fa-download"></i>Download All</button>
                            </form>
                            <button class="btn-transparent btn-red" id="btn-delete-files" data-action="all"><i class="fas fa-trash"></i>Delete All</button>
                            <button class="btn-transparent" id="btn-select-files" data-action="select"><i class="fas fa-select"></i>Select</button>
                        </div>
                    </div>
                    <div @class([ 'files-wrap', 'd-none' => $files->isEmpty() ])>
                        @foreach($files as $file)
                            @php 
                                $isImage = @getimagesize(url('/uploads/' . $file->source)) !== false; 
                            @endphp
                            <div class="file complete" data-src="{{ $file->source }}" data-file-id="{{ $file->id }}">
                                <div class="preview">
                                    @if($isImage)
                                        <img src="{{ url('/uploads/' . $file->source) }}" alt="{{ $file->name }}" class="img-preview">
                                    @else
                                        <i class="fas fa-file"></i>
                                        <p>{{ $file->name }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
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