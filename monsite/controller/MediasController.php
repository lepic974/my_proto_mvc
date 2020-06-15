<?php
class MediasController extends Controller
{

    function admin_index()
    {
        $this->theme = 'modal';
        $this->loadModel('Media');
        $d['images'] =$this->Media->find(array(

        ));
       $this->set($d);
    }

    function admin_delete($id){
        $this->loadModel('Media');
        $media =$this->Media->findFirst(array(
            'conditions'=>array('id'=>$id)

        ));
        unlink(WEBROOTT.DS.'img'.DS.$media->file);
        $this->Media->delete($id);
        $this->Session->setFlash("Votre image est bien Supprimer");
        $this->redirect('admin/medias/index/');
    }
}
