<section class="content-header">
  <h1>
    Blogelin
    <small>Panel de Control</small>
  </h1>
</section>

<section class="content">
  <!-- Info boxes -->
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-file-text"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Posts</span>
          <span class="info-box-number"><?php echo PostData::count(); ?></span>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-comment"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Comentarios</span>
          <span class="info-box-number"><?php echo CommentData::count(); ?></span>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-th-list"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Categorias</span>
          <span class="info-box-number"><?php echo CategoryData::count(); ?></span>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Usuarios</span>
          <span class="info-box-number"><?php echo UserData::count(); ?></span>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-8">
      <!-- Latest Posts -->
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title">Ultimos Posts</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table no-margin">
              <thead>
                <tr>
                  <th>Titulo</th>
                  <th>Fecha</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $posts = PostData::getLatest(5);
                foreach($posts as $post): ?>
                <tr>
                  <td><a href="./?view=posts"><?php echo $post->title; ?></a></td>
                  <td><?php echo $post->created_at; ?></td>
                  <td>
                    <?php if($post->status == 1): ?>
                      <span class="label label-success">Publicado</span>
                    <?php else: ?>
                      <span class="label label-warning">Borrador</span>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="box-footer clearfix">
          <a href="./?view=posts" class="btn btn-sm btn-info btn-flat pull-left">Nuevo Post</a>
          <a href="./?view=posts" class="btn btn-sm btn-default btn-flat pull-right">Ver todos</a>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <!-- Latest Comments -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Comentarios Recientes</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <ul class="products-list product-list-in-box">
            <?php 
            $comments = CommentData::getLatest(5);
            foreach($comments as $comment): 
              $p = PostData::getById($comment->post_id);
            ?>
            <li class="item">
              <div class="product-info" style="margin-left: 0;">
                <a href="javascript:void(0)" class="product-title"><?php echo $comment->name; ?>
                  <span class="label label-info pull-right"><?php echo $comment->created_at; ?></span></a>
                <span class="product-description">
                  <?php echo substr($comment->comment, 0, 50); ?>... 
                  <br>en <b><?php echo $p->title; ?></b>
                </span>
              </div>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <div class="box-footer text-center">
          <a href="./?view=comments" class="uppercase">Ver todos los comentarios</a>
        </div>
      </div>
    </div>
  </div>
</section>