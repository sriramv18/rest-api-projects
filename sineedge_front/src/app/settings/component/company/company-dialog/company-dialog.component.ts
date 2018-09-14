
import { Component, OnInit, Inject } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormControl } from '@angular/forms'; 
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material';
//import { CompanyService } from '../../../service/company.service';
import { MastersService } from '../../../service/master/masters.service';


@Component({
  selector: 'app-jazz-dialog',
  templateUrl: './company-dialog.component.html',
  styleUrls: ['./company-dialog.component.scss']
})
export class CompanyDialogComponent implements OnInit {


  public _companyForm: FormGroup;

  constructor(private _formBuilder: FormBuilder,
  private dialogRef: MatDialogRef<CompanyDialogComponent>,
  private _masterService: MastersService,
  @Inject(MAT_DIALOG_DATA) public data: any) { }

  onNoClick(): void {
    this.dialogRef.close();
   }
  
  ngOnInit() {

      this._companyForm = this._formBuilder.group({
        //Company_id: any; fk_city_id: any;
        // <!-- displayedColumns = ['company_id', 'name', 'addressline1', 'addressline2','addressline3', 'city', 'state',  'pincode', 'logo']; -->
        company_id: [this.data.company_id],
          name: [this.data.name, Validators.compose([Validators.required])],
          addressline1: [this.data.addressline1, Validators.compose([Validators.required])],
          addressline2: [this.data.addressline2, Validators.compose([Validators.required])],
          addressline3: [this.data.addressline3, Validators.compose([Validators.required])],
          city: [this.data.city, Validators.compose([Validators.required])],
          state: [this.data.state, Validators.compose([Validators.required])],
          pincode: [this.data.pincode, Validators.compose([Validators.required, Validators.minLength(5), Validators.maxLength(6)])],
          logo : [this.data.logo, Validators.compose([Validators.required])]
          
      });
  }

  // onSubmit() {
  //   if (isNaN(this.data.ID)) {
  //     this._companyService.addCompany(this._companyForm.value);
  //     this.dialogRef.close();
  //   } else {
  //     this._companyService.editCompany(this._companyForm.value);
  //     this.dialogRef.close();
  //   }
  // }

  onSubmit() {
    if(isNaN(this.data.company_id)) {
      var my_array = this._companyForm.value;
      Object.keys(my_array).forEach((key) => ( my_array[key] == null) && delete my_array[key]);
      console.log(my_array);
      this._masterService.addMasterDetails(my_array,'COMPANY').subscribe();
      this.dialogRef.close();
      alert("saved");
    } else {
      
      this._masterService.editMasterDetails(this._companyForm.value,'COMPANY').subscribe();
      this.dialogRef.close();
      alert("edited");
    }
  }

  

  onReset(){
    this._companyForm.reset();
  }
}
