<?php
/**
 * Created by PhpStorm.
 * User: david_000
 * Date: 9/01/2015
 * Time: 8:13
 */

namespace Ui\ApiBundle\Controller;

use CoreDomain\TimeSlot\TimeSlotId;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;

use FOS\RestBundle\View\ViewHandler;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Ui\SharedBundle\Request\TrackTimeRequest;

class TimeSlotController extends Controller
{
    /**
     * Lists all time slots
     *
     * @Rest\View
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     */
    public function allAction()
    {
        $timeSlots = $this->get('time_slot_repository')->findAll();

        return array('timeSlots' => $timeSlots);
    }

    /**
     * Presents the form to use to create a new time slot.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Rest\View()
     *
     * @param Request $request
     * @return FormTypeInterface
     * @throws AccessDeniedException
     */
    public function newTimeSlotAction(Request $request)
    {
        return $this->createForm('track_time');
    }

    /**
     * Creates a new time slot from the submitted data
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "ApiBundle\Form\TimeSlotType",
     *   statusCodes = {
     *     201 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Rest\View(
     *   template = "ApiBundle:TimeSlot:newTimeSlot.html.twig",
     *   statusCode = Codes::HTTP_BAD_REQUEST
     * )
     *
     * @param Request $request
     * @return array|\FOS\RestBundle\View\View
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \Doctrine\ORM\ORMException
     */
    public function postTimeSlotAction(Request $request)
    {

        // 2 ways of handling a form:

        // ---> METHOD 1 (explicit - optionsResolver component)
        //
        //    From: http://symfony.com/blog/push-it-to-the-limits-symfony2-for-high-performance-needs
        //
        //    You could use Form Component (see METHOD 2 below), build request structure in a Form Type and pass Request to it. It's nice and has rich features, but comes with huge overhead. We also didn't need or want advanced options like having nested fields.
        //    Another way would be to pass data in a request's content in a JSON structure. Use a Serializer component (like great JMSSerializer or even Symfony Serializer Component) and validate resulting DTO Request's objects. There are still two points that could lead to performance bottleneck: serializing and validating with the Validator Component.
        //    Thus, we didn't need any advanced validation (just checking required options and some basic format validation). Requests' format structure is also designed to be simple, and we've chosen... OptionsResolver Component. It's the same one you use when making options for your forms. We pass to it the GET array and on the output we receive a nicely validated and structured model object (it's an array to DTO normalization).
        try {

            if ($trackTimeRequest = new TrackTimeRequest($request->request->get('track_time'))) {
                $this->get('command_handler.track_time')->handle($trackTimeRequest->getData());

                return $this->get('fos_rest.view_handler')->handle(View::create(null, 201));
            }

        } catch (InvalidArgumentException $e) {

            return array(
                'errorMessage' => $e->getMessage()
            );

        }

        // ---> METHOD 2 (implicit - form component)
        $handler = $this->get('form_handler.track_time');

        $form = $this->createForm('track_time');

        if ($handler->handle($form, $request)) {
            return $this->get('fos_rest.view_handler')->handle(View::create(null, 201));
        }

        return array(
            'form' => $form
        );
    }

    /**
     * Delete a time slot
     *
     * @ApiDoc(
     *   resource = true,
     *   requirements= {
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "description"="the time slot's id"
     *      }
     *   },
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     404 = "Returned when the time slot was not found"
     *   }
     * )
     *
     * @Rest\View(statusCode=204)
     *
     * @param Request $request
     * @param $id
     * @throws HttpException
     */
    public function deleteTimeSlotAction(Request $request, $id)
    {
        $repository = $this->get('time_slot_repository');
        $timeSlot = $repository->find(new TimeSlotId($id));

        if (null === $timeSlot) {
            throw new HttpException(404);
        }

        $repository->remove($timeSlot);
    }
}