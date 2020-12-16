<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Builder\ListRequestDataBuilder;
use App\Entity\EmployeeEntity;
use App\Form\EmployeeEntityType;
use App\Repository\EmployeeEntityRepository;

/**
 * @Route("/employee")
 */
class EmployeeController extends AbstractController {

    protected const RESPONSE_EMPLOYEE = 'employee';
    protected const RESPONSE_FORM = 'form';
    protected const RESPONSE_RECORDS_TOTAL = 'recordsTotal';
    protected const RESPONSE_RECORDS_FILTERED = 'recordsFiltered';
    protected const RESPONSE_DATA = 'data';

    /**
     * @var ListRequestDataBuilder
     */
    protected $ListRequestDataBuilder;

    /**
     * @param ListRequestDataBuilder $ListRequestDataBuilder
     */
    public function __construct(ListRequestDataBuilder $ListRequestDataBuilder) {
        $this->ListRequestDataBuilder = $ListRequestDataBuilder;
    }

    /**
     * @Route("/", name="employee_index", methods={"GET"})
     */
    public function index(): Response {
        return $this->render('employee/index.html.twig', []);
    }

    /**
     * @Route("/list", name="employee_list", methods={"POST"})
     */
    public function list(Request $request): Response {
        /** @var EmployeeEntityRepository $repository */
        $repository = $this->getDoctrine()->getRepository(EmployeeEntity::class);

        $data = $this->ListRequestDataBuilder->build($request);

        $recordsTotal = $recordsFiltered = $repository->countAllEmployee();

        if ($data->hasFieldSearch()) {
            $recordsFiltered = $repository->countEmployeeBYListRequest($data);
        }

        return $this->json([
            self::RESPONSE_RECORDS_TOTAL => $recordsTotal,
            self::RESPONSE_RECORDS_FILTERED => $recordsFiltered,
            self::RESPONSE_DATA => $repository->findAllEmployeeBYListRequest($data)
        ]);
    }

    /**
     * @Route("/new", name="employee_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response {
        $employeeEntity = new EmployeeEntity();
        $form = $this->createForm(EmployeeEntityType::class, $employeeEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employeeEntity);
            $entityManager->flush();

            return $this->redirectToRoute('employee_index');
        }

        return $this->render('employee/new.html.twig', [
            self::RESPONSE_EMPLOYEE => $employeeEntity,
            self::RESPONSE_FORM => $form->createView(),
        ]);
    }

    /**
     * @Route("/{emp_no}", name="employee_show", methods={"GET"})
     */
    public function show(EmployeeEntity $employeeEntity): Response {
        return $this->render('employee/show.html.twig', [
            self::RESPONSE_EMPLOYEE => $employeeEntity,
        ]);
    }

    /**
     * @Route("/{emp_no}/edit", name="employee_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EmployeeEntity $employeeEntity): Response {
        $form = $this->createForm(EmployeeEntityType::class, $employeeEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employee_index');
        }

        return $this->render('employee/edit.html.twig', [
            self::RESPONSE_EMPLOYEE => $employeeEntity,
            self::RESPONSE_FORM => $form->createView(),
        ]);
    }

    /**
     * @Route("/{emp_no}", name="employee_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EmployeeEntity $employeeEntity): Response {
        if ($this->isCsrfTokenValid('delete' . $employeeEntity->getEmpNo(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($employeeEntity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('employee_index');
    }
}
