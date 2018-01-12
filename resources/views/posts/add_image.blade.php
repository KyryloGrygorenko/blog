@extends('layouts.master')

@section('content')
<table class="table table-striped books-list-table" >
    <tr>
        <td>
            <div class="row">

                    <div style="max-height: 300px; overflow: scroll" >
                        <?php foreach ($all_images as $image):?>


                        <?php if(file_exists(public_path() .'/img/' .$image)) { ?>
                        <input type = "image"  disabled value=""  src = "/img/<?=$image?>" width="100px" height="65px"/>
                        <input type="radio" name="img" value="<?=$image?>" >
                        <?php } else{?>

                        <input type = "image" name="img" disabled value="<?=$image?>" src = "/img/default.jpeg" width="100px" height="65px"/>
                        <?php } ?>
                        <?php endforeach;?>
                    </div>



                    <br>




                </form>
                <br>
                <br>
                <form method="post" enctype="multipart/form-data">
                    <h3>Upload new image on server </h3>
                    <input type="file" name="document" >
                    <button>Upload</button>
                </form>

            </div>
        </td>
    </tr>

    </tbody>
</table>
@endsection



