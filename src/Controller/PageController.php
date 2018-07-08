<?php
    namespace App\Controller;

    use App\Entity\Email;

    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Annotation\Route;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;

    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\EmailType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;


    class PageController extends Controller {
        /**
         * @Route("/", name="home")
         * @Method({"GET"})
         */
        public function index() {
            // return new Response("<html><body>Hello World</body></html>");

            return $this->render('pages/index.html.twig');
        }

        /**
         * @Route("/en/about", name="about")
         * @Method({"GET"})
         */
        public function about() {
            return $this->render('pages/about.html.twig');
        }

        /**
         * @Route("/en/area", name="area")
         * @Method({"GET"})
         */
        public function area(){
            return $this->render('pages/area.html.twig');
        }

        /**
         * @Route("/en/prices", name="prices")
         * @Method({"GET"})
         */
        public function prices(){
            return $this->render('pages/prices.html.twig');
        }

        /**
         * @Route("/en/contact",name="contact")
         * Method({"GET","POST"})
         */
        public function new(Request $request){
            $email = new Email();

            $form = $this->createFormBuilder($email)
            ->add('name',TextType::class, array(
                'attr'=> array('class'=>'form-control')))
            ->add('email',EmailType::class,array(
                'attr'=> array('class'=>'form-control')))
            ->add('message',TextareaType::class,array(
                'attr'=> array('class'=>'form-control')))
            ->add('send',SubmitType::class,array(
                'label'=>'Send',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $email = $form->getData();

                // Store to DB:
                // $entityManager = $this->getDoctrine()->getManager();
                // $entityManager->persist($email);
                // $entityManager->flush();

                $transport = (new \Swift_SmtpTransport($_ENV["MAILER_HOST"], $_ENV["MAILER_PORT"],'tls'))
                ->setUsername($_ENV["MAILER_USERNAME"])
                ->setPassword($_ENV["MAILER_PASSWORD"])
                ;
                $mailer = new \Swift_Mailer($transport);
                $sendEmail = $this->sendEmail($email->getName(),$email->getEmail(),$email->getMessage(), $mailer);

                return $this->redirectToRoute('thankyou');
            }

            return $this->render('pages/contact.html.twig', array(
                'form' => $form->createView()
            ));
        }

        public function sendEmail($name, $email, $message, \Swift_Mailer $mailer) {
            $message = (new \Swift_Message('Hello Skye'))
                ->setFrom('admin@chagnolet.com')
                ->setTo($_ENV["MAILER_RECIPIENT"])
                ->setBody(
                    $this->renderView(
                        // templates/emails/message.html.twig
                        'emails/message.html.twig',
                        array(
                            'name' => $name,
                            'email' => $email,
                            'message' => $message
                        )
                    ),
                    'text/html'
                )
                /*
                 * If you also want to include a plaintext version of the message
                ->addPart(
                    $this->renderView(
                        'emails/registration.txt.twig',
                        array('name' => $name)
                    ),
                    'text/plain'
                )
                */
            ;
        
            $mailer->send($message);
        
            // return $this->render(...);
        }

        /**
         * @Route("/en/thankyou", name="thankyou")
         * @Method({"GET"})
         */
        public function thankyou(){
            return $this->render('pages/thankyou.html.twig');
        }

        /**
         * @Route("/fr/", name="homefr")
         * @Method({"GET"})
         */
        public function indexfr() {
            // return new Response("<html><body>Hello World</body></html>");

            return $this->render('pages/indexfr.html.twig');
        }

        /**
         * @Route("/fr/renseignements", name="aboutfr")
         * @Method({"GET"})
         */
        public function aboutfr() {
            return $this->render('pages/aboutfr.html.twig');
        }

        /**
         * @Route("/fr/environs", name="areafr")
         * @Method({"GET"})
         */
        public function areafr(){
            return $this->render('pages/areafr.html.twig');
        }

        /**
         * @Route("/fr/prix", name="pricesfr")
         * @Method({"GET"})
         */
        public function pricesfr(){
            return $this->render('pages/pricesfr.html.twig');
        }

        /**
         * @Route("/fr/contact",name="contactfr")
         * Method({"GET","POST"})
         */
        public function newfr(Request $request){
            $email = new Email();

            $form = $this->createFormBuilder($email)
            ->add('nom',TextType::class, array(
                'attr'=> array('class'=>'form-control')))
            ->add('email',EmailType::class,array(
                'attr'=> array('class'=>'form-control')))
            ->add('message',TextareaType::class,array(
                'attr'=> array('class'=>'form-control')))
            ->add('send',SubmitType::class,array(
                'label'=>'Envoyer',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $email = $form->getData();

                // Store to DB:
                // $entityManager = $this->getDoctrine()->getManager();
                // $entityManager->persist($email);
                // $entityManager->flush();

                $transport = (new \Swift_SmtpTransport($_ENV["MAILER_HOST"], $_ENV["MAILER_PORT"],'tls'))
                ->setUsername($_ENV["MAILER_USERNAME"])
                ->setPassword($_ENV["MAILER_PASSWORD"])
                ;
                $mailer = new \Swift_Mailer($transport);
                $sendEmail = $this->sendEmail($email->getName(),$email->getEmail(),$email->getMessage(), $mailer);

                return $this->redirectToRoute('thankyoufr');
            }

            return $this->render('pages/contactfr.html.twig', array(
                'form' => $form->createView()
            ));
        }

        /**
         * @Route("/fr/thankyou", name="thankyoufr")
         * @Method({"GET"})
         */
        public function thankyoufr(){
            return $this->render('pages/thankyoufr.html.twig');
        }
    }
?>