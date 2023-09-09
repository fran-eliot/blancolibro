<?php

namespace App\Controller;

use App\Entity\Seccion;
use App\Entity\Apartado;
use App\Entity\Subapartado;
use App\Entity\Cita;
use App\Entity\Audiovisual;
use App\Form\SeccionType;
use App\Repository\SeccionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EscenaController extends AbstractController
{
    #[Route('/escena/{id}',name: 'app_escena', methods: ['GET'])]
    public function index($id): Response
    {
        $secciones=[];
        if($id==1){
            $secciones = [2,3];
        } else if ($id==2){
            $secciones = [4,7];
        } else if ($id==3){
            $secciones = [5,6];
        } else if ($id==4){
            $secciones = [8,1];
        } 

        if (!$secciones) {
            return $this->json(['message' => 'No se encontró la escena'], 404);
        }

        $dataEscena=[];
        $entityManager = $this->getDoctrine()->getManager();
        foreach($secciones as $idSeccion){
            $seccion = $entityManager->getRepository(Seccion::class)->find($idSeccion);

            if (!$seccion) {
                return $this->json(['message' => 'No se encontró la sección'], 404);
            }

           
            $dataSesion = [
                'idSeccion' => $seccion->getId(),
                'tituloSeccion' => $seccion->getTituloSeccion(),
                'apartados' => [],
                'citas' => [],
                'audiovisuales' => [],
            ];
    
            foreach ($seccion->getApartados() as $apartado) {
                $dataApartado = [
                    'idApartado' => $apartado->getId(),
                    'tituloApartado' => $apartado->getTituloApartado(),
                    'contenidoApartado' => $apartado->getContenidoApartado(),
                    'subapartados' => [],
                    'citasApartado' => [],
                    'audiovisualesApartado' => [],
                ];
    
                foreach ($apartado->getSubapartados() as $subapartado) {
                    $dataSubapartado = [
                        'idSubapartado' => $subapartado->getId(),
                        'tituloSubapartado' => $subapartado->getTituloSubapartado(),
                        'contenidoSubapartado' => $subapartado->getContenidoSubapartado(),
                        'citasSubapartado' => [],
                        'audiovisualesSubapartado' => [],
                    ];
    
                    foreach ($subapartado->getCitas() as $cita) {
                        $dataSubapartado['citasSubapartado'][] = [
                            'idCita' => $cita->getId(),
                            'contenidoCita' => $cita->getContenidoCita(),
                        ];
                    }
    
                    foreach ($subapartado->getAudiovisuals() as $audiovisual) {
                        $dataSubapartado['audiovisualesSubapartado'][] = [
                            'idAudiovisual' => $audiovisual->getId(),
                            'rutaAudiovisual' => $audiovisual->getRutaAudiovisual(),
                            'pieAudiovisual' => $audiovisual->getPieAudiovisual(),
                        ];
                    }
    
                    $dataApartado['subapartados'][] = $dataSubapartado;
                }
    
                foreach ($apartado->getCitas() as $cita) {
                    $dataApartado['citasApartado'][] = [
                        'idCita' => $cita->getId(),
                        'contenidoCita' => $cita->getContenidoCita(),
                    ];
                }
    
                foreach ($apartado->getAudiovisuals() as $audiovisual) {
                    $dataApartado['audiovisualesApartado'][] = [
                        'idAudiovisual' => $audiovisual->getId(),
                        'rutaAudiovisual' => $audiovisual->getRutaAudiovisual(),
                        'pieAudiovisual' => $audiovisual->getPieAudiovisual(),
                    ];
                }
    
                $dataSesion['apartados'][] = $dataApartado;
            }
    
            foreach ($seccion->getCitas() as $cita) {
                $dataSesion['citas'][] = [
                    'idCita' => $cita->getId(),
                    'contenidoCita' => $cita->getContenidoCita(),
                ];
            }
    
            foreach ($seccion->getAudiovisuals() as $audiovisual) {
                $dataSesion['audiovisuales'][] = [
                    'idAudiovisual' => $audiovisual->getId(),
                    'rutaAudiovisual' => $audiovisual->getRutaAudiovisual(),
                    'pieAudiovisual' => $audiovisual->getPieAudiovisual(),
                ];
            }

            $dataEscena[]=$dataSesion;
        }

        return $this->json($dataEscena);

    }
        

 

        

      
    
}

