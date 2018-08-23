<?php
/**
 * Created by PhpStorm.
 * User: karthi
 * Date: 11/13/17
 * Time: 8:03 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_model extends CI_Model {

    /*
     * add branch details
     * params:branchcode,branchname,email,address,mobilenumber,activestatus
     * created by kms
     * */

    public function addBranch($arrayDetails=null, $imageSource)
    {
      
        $target = "../images/logo/";
        $getUploadStatus = $this-> upload_image($imageSource, $target);
        $imageNameDb = $getUploadStatus['imageName'];
        $arrayDetails['LogoPath'] = $getUploadStatus == true ?  "logo/".$imageNameDb : '';
//   print_r($arrayDetails['IsActive']);exit();
        $this->db->select('BranchCode');
        $this->db->where('BranchCode', $arrayDetails['BranchCode']);
        if($this->db->get(BRANCH)->first_row()){
            $result['BranchStatus'] = false;
            $result['message'] = "This branch code is already exist!";
        } else {
            $this->db->select('BranchName');
            $this->db->where('BranchName', $arrayDetails['BranchName']);
            if($this->db->get(BRANCH)->first_row()){
                $result['BranchStatus'] = false;
                $result['message'] = "This branch name is already exist!";
            } else{
                $this->db->insert(BRANCH, $arrayDetails);
                if($this->db->affected_rows() == '1'){

                    $result['branchStatus'] = true;
                    $result['message'] = "Successfully branch details added";
                }

                else {
                    $result['branchStatus'] = false;
                    $result['message'] = "Something went wrong.please try again";
                }
        } 

        }
        


        return $result;

    }
    /*
     * get branch details
     * parama id
     * created by kms
     * */

    public function getBranch()
    {
        $this->db->select('BranchCode,BranchName,LogoPath,MobileNumber,AlternateNumber,LandlineNumber,Address,EmailID,CreatedOn,IsActive,FeesReceiptTitle as feesTitle');
        $this->db->order_by('CreatedOn','DESC');
        $branchDetails = $this->db->get(BRANCH);

        if($branchDetails->result()){

            $result['branchStatus'] = true;
            $result['details'] = $branchDetails->result();
        }
        else {
            $result['branchStatus'] = false;
            $result['message'] = "No records found!";
        }

        return $result;

    }
    /*
     * update branch details
     * created by kms
     * */

    public function updateBranch($arrayDetails=null,$branchCode=null, $imageSource, $imageStat)
    {
        if( $imageStat == 1 ) {
        $target = "../images/logo/";
        $getUploadStatus = $this-> upload_image($imageSource, $target);
        $imageNameDb = $getUploadStatus['imageName'];
        $arrayDetails['LogoPath'] = $getUploadStatus == true ?  "logo/".$imageNameDb : null;
        } else {

        }
   
//   print_r($arrayDetails['IsActive']);exit();

            $this->db->where('BranchCode',$branchCode);
            $upateStatus=$this->db->update(BRANCH, $arrayDetails);
            if($upateStatus){
                $result['branchStatus'] = true;
                $result['message'] = "Successfully branch details updated";
            }

            else {
                $result['branchStatus'] = false;
                $result['message'] = "Something went wrong.please try again";

        }


        return $result;

    }

    // image upload in taget path
    public function upload_image( $imageSource, $target ) {
        $key2 = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 12);
        $new_regNo = "Dri_" . $key2 . "." . 'jpeg';
        $targetPlace = $target . $new_regNo;
        // echo $targetPlace;exit();
        if(!move_uploaded_file($imageSource , $targetPlace))
            {
                return $result['status'] = false;
            } else {
                $result['status'] = true;
                $result['imageName'] = $new_regNo;
                return $result;
            }
    }
        // student document upload target path
    public function uploadFiles($resource=null) {
        $target="myDocs/";
        $key2 = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 12);
        $new_regNo = "Dri_".$key2."_".$resource['doc_name'];
        $targetPlace = $target . $new_regNo;
        // echo $targetPlace;exit();
        if (!move_uploaded_file($resource['doc_source'], $targetPlace)) {
            return $result['uploadStatus'] = false;
        } else {
            $result['uploadStatus'] = true;
            $result['sourceName'] = $new_regNo;
            return $result;
        }
    }


}