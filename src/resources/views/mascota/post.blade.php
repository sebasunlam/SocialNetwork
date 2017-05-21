<form role="form" method="POST" action="{{ route('mascota.post',['id'=>$mascota->id]) }}"
      enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="postModalLabel">Habla por {{$mascota->nombre}}</h4>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="form-horizontal">
                            <div class="row">

                                <div class="radio col-md-3">
                                    <label>
                                        <input type="radio" name="optionsRadios" id="optionsRadios1" value="comment"
                                               checked>
                                        Comentario
                                    </label>
                                </div>
                                <div class="radio col-md-3">
                                    <label>
                                        <input type="radio" name="optionsRadios" id="optionsRadios2" value="image">
                                        Imagen
                                    </label>
                                </div>
                                <div class="radio col-md-3">
                                    <label>
                                        <input type="radio" name="optionsRadios" id="optionsRadios3" value="video">
                                        Video (Online)
                                    </label>
                                </div>
                            </div>
                            <br>
                            <div id="imageData" align="center">
                                <div class="row">
                                    <div class="col-sm-12" align="center">
                                        <img id="postImg" src="" alt="Suba una imagen"
                                             class="img-responsive img-thumbnail postImg">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" align="center">
                                        <div>
                                            <label class="btn btn-info btn-file">
                                                Agregar imagen... <input type="file" name="photo" id="photo" hidden> |
                                                <i class="fa fa-file" aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">

                                <div class="form-group">
                                    <label for="content" class="col-sm-2 control-label">Comentario</label>
                                    <div class=" col-sm-5">
                                    <textarea name="content" id="content"
                                              class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group" id="videoData">
                                    <label for="videoUrl" class="col-sm-2 control-label">Url</label>
                                    <div class="col-sm-5">
                                        <input type="text" id="videoUrl" name="videoUrl" class="form-control"/>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Postear</button>
                </div>
            </div>
        </div>
    </div>
</form>