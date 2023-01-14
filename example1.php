if( $_POST['tour_go'] ) {
    $checktourname = DBQuery(" SELECT * FROM le_tours WHERE tour_name='$_POST[tour_name]'");
    if( mysqli_num_rows($checktourname) > 0 ) {
        $tour_alias = mb_strtolower( translit($_POST['tour_name']) ). '-' .( mysqli_num_rows($checktourname) + 1 );
    } else {
        $tour_alias = mb_strtolower( translit($_POST['tour_name']) );
    }

    $tour_name = dbfilter( $_POST['tour_name'] );
    $tour_desc = dbfilter( $_POST['tour_desc'] );
    $tour_routedesc = dbfilter( $_POST['tour_routedesc'] );
    $tour_programmdesc = dbfilter( $_POST['programm_desc'] );

    $tour_edits = json_encode( array( [$_SESSION['user_id'] => CURR_DATETIME] ) );
    $tour_img = img_compress( $_FILES['tour_img']['tmp_name'], 'tour_'.time(), DIR_IMG_TOURS );
    $tour_routeimg = img_compress( $_FILES['tour_routeimg']['tmp_name'], 'tourroute_'.time(), DIR_IMG_TOURS );
    if( $_POST['tour_programm'] ) {
        $tour_programm = dbfilter( json_encode( $_POST['tour_programm'] ) );

        $programm_imgs = [];
        $programm_imgs_it = 0;
        if( $_FILES['programm_img']['tmp_name'][0] ) {
            foreach( $_FILES['programm_img']['tmp_name'] as $programm_img ) {
                $programm_imgs[] = img_compress(
                    $programm_img,
                    'tourprogramm_'.time().$programm_imgs_it,
                    DIR_IMG_TOURS
                );
                $programm_imgs_it++;
            }
        }
        $programm_imgs = json_encode( $programm_imgs );

        $programmapart_imgs = [];
        $programmapart_imgs_it = 0;
        if( $_FILES['programm_apart_img']['tmp_name'][0] ) {
            foreach( json_decode($_POST['tour_apartimgs'] , true) as $tour_apartimg_k => $tour_apartimg_el ) {
                if( $tour_apartimg_el == 1) {
                    $programmapart_imgs[$tour_apartimg_k] = img_compress(
                        $_FILES['programm_apart_img']['tmp_name'][$programmapart_imgs_it],
                        'tourprogrammapart_'.time().$programmapart_imgs_it,
                        DIR_IMG_TOURS
                    );
                    $programmapart_imgs_it++;
                }
            }
        }
        $programmapart_imgs = json_encode( $programmapart_imgs );
    }
    if( $_POST['tour_services'] ) {
        $tour_services = dbfilter( json_encode( $_POST['tour_services'] ) );
    }
    if( $_POST['tour_noservices'] ) {
        $tour_noservices = dbfilter( json_encode( $_POST['tour_noservices'] ) );
    }
}
