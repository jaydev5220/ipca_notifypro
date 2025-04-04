<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Vendor extends CI_Controller
{

  public function __construct()
  {

    //load helper
    parent::__construct();
    //load model
    $this->load->model('Notification_model');
  }

  public function index()
  {
    $data = [];
    $data['title'] = 'Notification Template';



    $this->load->view('header', $data);
    $this->load->view('vendor/index');
    $this->load->view('footer');
  }

  public function expense($token)
  {
    $data = [];
    $data['title'] = 'Expenses';

    if ($token) {
      $notification_details = $this->Notification_model->get_notification_details_by_token($token);

      if (!empty($notification_details)) {
        $category_id = $notification_details['category_id'];
        $data['category_name'] = get_category_name($category_id);

        $data_type = $this->Notification_model->get_upload_type();
        if (!empty($data_type)) {
          $type = explode(',', $data_type['value']);
          $extensions = array_map(function ($value) {
            return '.' . $value;
          }, $type);

          $result = implode(', ', $extensions);
          $data['allowed_types'] = $result;
        }

        $size = $this->Notification_model->get_upload_size();
        if (!empty($size)) {
          $data['max_size'] = $size['value'];
        }

        if (!empty($notification_details)) {
          $type_text = $notification_details['type_text'];

          $data['type_text'] = $type_text;
        }
        
        $data['notification_id'] = $notification_details['id'];
        $data['max_file'] = ($notification_details['no_of_attachments'] - $notification_details['document_count']);
      } else {
        redirect(base_url());
      }
    }

    $this->load->view('header', $data);
    $this->load->view('vendor/expense', $data);
    $this->load->view('footer');
  }
  //document add
  public function document_add()
  {

    if ($this->input->post()) {
      $response['status'] = 0;
      //data insert into notification table
      $notification_data = array(
        'status_2' => 'success',
        'bitly_url' => '',
        'date_received' => date('Y-m-d')
      );
      if ($this->Notification_model->update_notification($notification_data, $this->input->post('id'))) {
        $response['status'] = 1;
        $response['message'] = 'Document added successfully';
        $response['redirect_url'] = base_url('thank_you');
      } else {
        $response['status'] = 0;
        $response['message'] = 'Error adding document';
      }
      header('Content-Type: application/json');
      echo json_encode($response);
      die;
    }
  }


  public function addmore($id)
  {
    $data = [];
    $data['title'] = 'Add More';

    if ($id) {
      $id = base64_decode($id);
      $get_notification_document = $this->Notification_model->get_notification_document($id);
      $data['notification_document'] = $get_notification_document;
      $data['notification_id'] = $id;
      $notififction_details = $this->Notification_model->get_notification_details($id);
      if (!empty($notififction_details)) {

        if ($notififction_details['status_2'] == 'success') {
          redirect(base_url());
        }

        if (count($get_notification_document) == $notififction_details['no_of_attachments'] || $notififction_details['no_of_attachments'] < count($get_notification_document)) {
          $data['max_file'] = 0;
        } else {
          $data['max_file'] = $notififction_details['no_of_attachments'] - count($get_notification_document);
        }
      }
    }

    $this->load->view('header', $data);
    $this->load->view('vendor/addmore');
    $this->load->view('footer');
  }

  //vendor remove
  public function remove_document()
  {
    $response = array('status' => 0, 'message' => '');
    $id = $this->input->post('id');
    //before delete document 
    $get_notification_document_by_id = $this->Notification_model->get_notification_document_by_id($id);

    if ($this->Notification_model->delete_document($id)) {
      $newFilename = str_replace(' ', '_', $get_notification_document_by_id['document']);
      $filepath = FCPATH . 'uploads/' . $get_notification_document_by_id['notification_id'] . '/' . $newFilename;
      if (file_exists($filepath)) {
        unlink($filepath);
      }
      $response['status'] = 1;
      $response['message'] = 'Document deleted successfully';
    } else {
      $response['message'] = 'Error deleting document';
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    die;
  }


  // Thank you page
  public function thank_you()
  {
    $data = [];
    $data['title'] = 'Thank You';

    $this->load->view('header', $data);
    $this->load->view('vendor/thank_you');
    $this->load->view('footer');
  }

  public function do_upload()
  {
    $folder = FCPATH . 'uploads/';
    if (!is_dir($folder)) {
      mkdir($folder, 0777);
    }

    $notification_id = $this->input->post('notification_id');
    $document_text = $this->input->post('document_text');

    $filepath = FCPATH . 'uploads/' . $notification_id . '/';
    if (!is_dir($filepath)) {
      mkdir($filepath, 0777);
    }
    $path = $filepath;
    $data_type = $this->Notification_model->get_upload_type();
    $type = explode(',', $data_type['value']);
    $config['allowed_types'] = implode('|', $type);
    $config['max_size'] = $this->Notification_model->get_upload_size()['value'] * 1024;
    $config['upload_path'] = $path;
    // Initialize the upload library for each file
    $this->load->library('upload', $config);
    $response = array(); // Initialize the response array

    // Check if any files were uploaded
    if (!empty($_FILES['file']['name'][0])) {
      $data_type = $this->Notification_model->get_upload_type();




      $images = array();
      if (is_array($_FILES['file']['name'])) {

        // Process each uploaded file
        foreach ($_FILES['file']['name'] as $key => $filename) {
          $_FILES['images[]']['name'] = $_FILES['file']['name'][$key];
          $_FILES['images[]']['type'] = $_FILES['file']['type'][$key];
          $_FILES['images[]']['tmp_name'] = $_FILES['file']['tmp_name'][$key];
          $_FILES['images[]']['error'] = $_FILES['file']['error'][$key];
          $_FILES['images[]']['size'] = $_FILES['file']['size'][$key];

          // Generate a unique filename for each file
          $name_split = explode(".", $filename);
          $fileName = str_replace(' ', '_', current($name_split)) . '_' . time() . '.' . end($name_split);
          $config['file_name'] = $fileName;
          $images[] = $fileName;

          $this->upload->initialize($config);

          if ($this->upload->do_upload('images[]')) {
            // File uploaded successfully
            $response = array(
              'status' => 'success',
              'message' => 'Document uploaded successfully',
              'filename' => $fileName,
              'redirect_url' => base_url('vendor/addmore/') . base64_encode($notification_id),
            );

            // Insert the file name and document title into the database
            $document_data = array(
              'document' => $fileName,
              'notification_id' => $notification_id,
              'document_text' => $document_text,
            );
            $this->Notification_model->insert_document($document_data);

            // Generate and save a thumbnail if needed
            $thumbnail_path = $path . 'thumb/';
            if (!file_exists($thumbnail_path)) {
              mkdir($thumbnail_path, 0777, true);
            }
            $file = $path . $fileName;
            $im = new Imagick($file);
            $noOfPagesInPDF = $im->getNumberImages();
            if ($noOfPagesInPDF) {
              for ($i = 0; $i < 1; $i++) {
                $url = $file . '[' . $i . ']';
                $image = new Imagick();
                $image->setResolution(50, 50);
                $image->readimage($url);
                $image->resizeImage(200, 200, Imagick::FILTER_LANCZOS, 1);
                $image->setImageFormat("jpg");
                $image->writeImage($thumbnail_path . $fileName . '.jpg');
              }
            }
          } else {

            $response = array(
              'status' => 'error',
              'message' => $this->upload->display_errors(),
            );
          }
        }
      } else {
        if (!empty($_FILES['file']['name'])) {
          // Generate a unique filename for the file
          $name_split = explode(".", $_FILES['file']['name']);
          $fileName = str_replace(' ', '_', current($name_split)) . '_' . time() . '.' . end($name_split);
          $config['file_name'] = $fileName;

          $this->upload->initialize($config);

          if ($this->upload->do_upload('file')) {
            // File uploaded successfully
            // Insert the file name and document title into the database
            $document_data = array(
              'document' => $fileName,
              'notification_id' => $notification_id,
              'document_text' => $document_text,
            );
            $this->Notification_model->insert_document($document_data);

            // Generate and save a thumbnail if needed
            $thumbnail_path = $path . 'thumb/';
            if (!file_exists($thumbnail_path)) {
              mkdir($thumbnail_path, 0777, true);
            }
            $file = $path . $fileName;
            $im = new Imagick($file);
            $noOfPagesInPDF = $im->getNumberImages();
            if ($noOfPagesInPDF) {
              for ($i = 0; $i < 1; $i++) {
                $url = $file . '[' . $i . ']';
                $image = new Imagick();
                $image->setResolution(50, 50);
                $image->readimage($url);
                // Resize the image to your desired dimensions (e.g., 200x200)
                $image->resizeImage(200, 200, Imagick::FILTER_LANCZOS, 1);

                $image->setImageFormat("jpg");
                $image->writeImage($thumbnail_path . $fileName . '.jpg');
              }
            }
          }
          $response = array(
            'status' => 'success',
            'message' => 'Document uploaded successfully',
            'filename' => $fileName,
            'redirect_url' => base_url('vendor/addmore/') . base64_encode($notification_id),
          );
        } else {
          $response = array(
            'status' => 'error',
            'message' => 'No files selected for upload.',
          );
        }
      }
    } else {
      // No files were uploaded
      $response = array(
        'status' => 'error',
        'message' => 'No files selected for upload.',
      );
    }
    // Send the response as JSON
    echo json_encode($response);
  }

  //document download
  public function download_file($id)
  {

    $get_notification_document_by_id = $this->Notification_model->get_notification_document_by_id($id);
    if (empty($get_notification_document_by_id)) {
      redirect(base_url());
    }
    //space remove and st _ in image name
    $get_notification_document_by_id['document'] = str_replace(' ', '_', $get_notification_document_by_id['document']);

    $filepath = FCPATH . 'uploads/' . $get_notification_document_by_id['notification_id'] . '/' . $get_notification_document_by_id['document'];
    if (file_exists($filepath)) {
      $this->load->helper('download');
      force_download($filepath, NULL);
    } else {
      redirect(base_url());
    }
  }

  public function view_file($id)
  {
    $data = [];
    $data['title'] = 'View File';

    $document = $this->Notification_model->get_notification_document_by_id($id);

    if ($document) {
      $file_path = FCPATH . 'uploads/' . $document['notification_id'] . '/' . $document['document'];

      if (file_exists($file_path)) {
        $any_view = mime_content_type($file_path);

        // Set headers to open the file in a new tab
        header('Content-Type: ' . $any_view);
        header('Content-Disposition: inline; filename="' . $document['document'] . '"');
        header('Content-Length: ' . filesize($file_path));

        readfile($file_path);
        exit;
      } else {
        show_404('File not found');
      }
    } else {
      show_404('Document not found');
    }
  }
}
