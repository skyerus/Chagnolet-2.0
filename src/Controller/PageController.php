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
         * @Route("/about")
         * @Method({"GET"})
         */
        public function about() {
            return $this->render('pages/about.html.twig');
        }

        /**
         * @Route("/area")
         * @Method({"GET"})
         */
        public function area(){
            return $this->render('pages/area.html.twig');
        }

        /**
         * @Route("/prices")
         * @Method({"GET"})
         */
        public function prices(){
            return $this->render('pages/prices.html.twig');
        }

        // /**
        //  * @Route("/contact")
        //  * @Method({"GET"})
        //  */
        // public function contact(){
        //     return $this->render('pages/contact.html.twig');
        // }

        /**
         * @Route("/contact",name="send_email")
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

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($email);
                $entityManager->flush();

                // $transport = (new \Swift_SmtpTransport('auth.smtp.1and1.co.uk', 587))
                // ->setUsername('skye.gill@chagnolet.com')
                // ->setPassword('Maubuisson!09')
                // ;

                $transport = (new \Swift_SmtpTransport($_ENV["MAILER_HOST"], $_ENV["MAILER_PORT"]))
                ->setUsername($_ENV["MAILER_USERNAME"])
                ->setPassword($_ENV["MAILER_PASSWORD"])
                ;
                $mailer = new \Swift_Mailer($transport);
                $sendEmail = $this->sendEmail($email->getName(),$email->getEmail(),$email->getMessage(), $mailer);

                return $this->redirectToRoute('home');
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
    }
?>