import { Component, OnInit, ChangeDetectorRef, ViewChild, ElementRef,Pipe } from '@angular/core';

import { Router } from "@angular/router";
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms';
import { CustomValidators } from 'ng2-validation';
import { AwsService } from '../../aws.service';
import { FileUploader } from 'ng2-file-upload/ng2-file-upload';
import { SharedService } from '../../shared.service';
import { MatOption } from '@angular/material';
@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {
  img: any;
  roles: any;
  types: any;
  public regForm: FormGroup;

  // name: string;
  // email: string;
  // password: string;
  // passwordConfirm: string;
  entityType: any;
  City: any;
  State: any;
  designation: any;
  files: File = null
  usersData: any;
  sampledrop:any;
  @ViewChild('allSelected') private allSelected: MatOption;
  constructor(
    private router: Router, public fb: FormBuilder, public AWS: AwsService, private cd: ChangeDetectorRef
    , public shared: SharedService,private elementRef: ElementRef) { }
  ngOnInit() {
    if (this.AWS.localUserId != '' && this.AWS.localUserId != null && this.AWS.localUserId !== undefined) {

    } else {
      this.regdata();
    }
    this.roles = [
      { name: 'Admin', value: 'ADMIN' },
      { name: 'Audit', value: 'AUDIT' }
    ];

    this.regForm = this.fb.group({
      userid: [null],
      firstName: [null, Validators.compose([Validators.required, Validators.minLength(2), Validators.maxLength(10)])],
      lastName: [null, Validators.compose([Validators.required])],
      phone: [null, Validators.compose([Validators.required, Validators.minLength(10), Validators.maxLength(12)])],
      altphone: [null, Validators.compose([Validators.minLength(10), Validators.maxLength(12)])],
      email: [null, Validators.compose([Validators.required, CustomValidators.email])],
      altemail: [null, Validators.compose([CustomValidators.email])],
      role: [null, Validators.compose([Validators.required])],
      type: [null, Validators.compose([Validators.required])],
      address1: [null, ''],
      address2: [null, ''],
      address3: [null, ''],
      state: [null, Validators.compose([Validators.required])],
      city: [null, Validators.compose([Validators.required])],
      designation: [null, Validators.compose([Validators.required])],
      userpic: [null],
      isactive: [true],
      pincode: [null],

    });
    this.userupdate();

  }

  onSelect(e){
    alert();
    // console.log(e)
    // console.log(e.isUserInput);
    // console.log(this.regForm.controls['role'].value);
  }

  regdata() {
    this.AWS.entityType().subscribe(res => {
      if (res.status == 200) {
        this.types = res.records;
        console.log(this.types);
      }
    });
    this.AWS.City().subscribe(res => {
      if (res.status == 200) {
        this.City = res.records;
      }
    });
    this.AWS.State().subscribe(res => {
      if (res.status == 200) {
        this.State = res.records;
      }
    });
    this.AWS.designation().subscribe(res => {
      if (res.status == 200) {
        this.designation = res.records;
      }
    });
    //console.log(this.State+''+this.types+''+this.City+''+this.designation);
  }
  onFileChange($event) {
    console.log($event.target.files[0]);

    //if($event.target.files[0] < 0 ){
    this.files = $event.target.files[0];
    //}
    //console.log(this.files); 
  }
  register(userData) {
    console.log(userData);
    // console.log(this.files);
    if (this.usersData != '') {
      if (this.files) {
        userData.userpic = this.files;
      } else {
        userData.userpic = this.usersData.profilepic;
      }
    } else {
      if (this.files) {
        userData.userpic = this.files;
      }
    }
console.log(this.usersData);
    if (this.usersData === undefined) {
      this.AWS.register(userData).subscribe(res => {
        if (res.User.UserStatus != '' && res.User.UserStatus !== undefined && res.User.UserStatus != null) {
          this.AWS.saveRecords(res, userData).subscribe(res => {
            if (res.status == 200) {
              this.AWS.adminUpdateuser(userData, res.record).subscribe(res => {
                console.log(res);
                alert('user Created');
                this.shared.redirectTo('settings/userListing');
              });
            }
          })
        }
      });
    } else {
      this.AWS.adminchangeData(this.usersData,userData).subscribe(res=>{
          this.AWS.saveRecords(res,userData).subscribe(res=>{
            console.log(res);
          })
      })

    }
  }

  toggleAllSelection(e) {
    
    
    if (this.usersData != '' && this.usersData !==undefined) {
      let users: any; 
      console.log(this.usersData);
      //for (let role of this.usersData[0]) {
       //this.AWS.adminremoveGroup(roles,this.usersData);
       if(e.source.selected){
        this.AWS.UserGroup(e.source.value,this.usersData);
         
       }else{
        this.AWS.adminremoveGroup(e.source.value,this.usersData);
         console.log("else");
       }
        //this.AWS.adminremoveGroup()
     // }
     
    }

  }
  userupdate() {

    if (this.AWS.localUserId != '' && this.AWS.localUserId != null && this.AWS.localUserId !== undefined) {
      this.usersData = this.AWS.localUserId;
      console.log(this.usersData);
      this.AWS.entityType().subscribe(res => {
        if (res.status == 200) {
          this.types = res.records;
          let type = this.types.filter(type => type.entity_type_id == this.usersData.fk_entity_id)[0];
          this.regForm.controls['type'].setValue(type);
        }
      });
      this.AWS.City().subscribe(res => {
        if (res.status == 200) {
          this.City = res.records.filter(city => city.city_id == this.usersData.fk_city);
          this.regForm.controls['city'].setValue(this.City[0]);
          console.log(this.City);
        }
      });
      this.AWS.State().subscribe(res => {
        if (res.status == 200) {
          this.State = res.records.filter(state => state.state_id == this.usersData.fk_state);
          console.log(this.State);
          this.regForm.controls['state'].setValue(this.State[0]);
        }
      });
      this.AWS.designation().subscribe(res => {
        if (res.status == 200) {
          this.designation = res.records.filter(des => des.designation_id == this.usersData.fk_designation);
          this.regForm.controls['designation'].setValue(this.designation[0]);
        }
      });
      let userRole: any = [];
      console.log(this.usersData.profilepic);
      for (let role of this.usersData[0]) {
        //console.log(role);
        userRole.push(this.roles.filter(roles => roles.value == role.user_role)[0]);
        //console.log(userRole);
      }

      //console.log(userRole);
      // this.regForm.controls['firstName'].setValue({'firstName':'sriram'});
      this.regForm.controls['userid'].setValue(this.usersData.userid);
      this.regForm.controls['firstName'].setValue(this.usersData.user_first_name);
      this.regForm.controls['lastName'].setValue(this.usersData.user_last_name);
      this.regForm.controls['phone'].setValue(this.usersData.mobile_no);
      this.regForm.controls['altphone'].setValue(this.usersData.alt_mobile_no);
      this.regForm.controls['email'].setValue(this.usersData.email);
      this.regForm.controls['altemail'].setValue(this.usersData.alt_email);
      this.regForm.controls['address1'].setValue(this.usersData.addressline1);
      this.regForm.controls['address2'].setValue(this.usersData.addressline2);
      this.regForm.controls['address3'].setValue(this.usersData.addressline3);
      if (this.usersData.isactive == 1) {
        this.regForm.controls['isactive'].setValue(true);
      } else {
        this.regForm.controls['isactive'].setValue(false);
      }
      this.regForm.controls['role'].setValue(userRole);
      // this.regForm.controls['userpic'].setValue(this.usersData.profilepic);
      this.regForm.controls['pincode'].setValue(this.usersData.pincode);
      this.img = this.usersData.profilepic;
    }
  }

}
