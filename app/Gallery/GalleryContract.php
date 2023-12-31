<?php
    namespace App\Gallery;

    use Illuminate\Http\Request;

    interface GalleryContract{
        public function GetRows();
        public function GetAll();
        public function GetData($id);
        public function GetProductGallery($productId);
        public function Create(Request $request);
        public function Delete($id);
        public function DataFormat($galleryInfo);
    }
?>
