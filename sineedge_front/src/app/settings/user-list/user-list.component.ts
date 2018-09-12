import { Component, OnInit, ViewChild, } from '@angular/core';
import { Router, RouterOutlet } from '@angular/router';
import { AwsService } from '../../aws.service';
import { MatPaginator, MatTableDataSource } from '@angular/material';
import { SharedService } from '../../shared.service';
@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss']
})
export class UserListComponent implements OnInit {
  displayedColumns: string[] = ['position', 'name', 'weight', 'symbol'];

  userdata: any = [];
  loader: boolean = false;
  @ViewChild(MatPaginator) paginator: MatPaginator;

  constructor(public aws: AwsService, public route: Router, public shared: SharedService) { }




  ngOnInit() {
    this.getusers();
  }

  getusers() {
    this.loader = true;
    this.aws.getuserdata().subscribe(res => {
      this.loader = false;
      console.log(res);
      if (res.status == 200) {
        this.userdata = res.records;
      }
    })
  }
  isactive(id, awsname) {
    let userstatus = this.userdata.filter((users) => users.userid == id)[0];
    if (userstatus.isactive == 1) {
      this.aws.admindisabelUser(userstatus, awsname).subscribe(res => {
        if (res == 0) {
          let users = {
            'records': {
              'userid': userstatus.userid,
              'isactive': '0',
            }
          };
          this.aws.adminupendis(users).subscribe(res => {
            if (res.status == 200) {
              this.shared.redirectTo(this.route.url);
            }
          })
        }

      })
    } else {
      this.aws.adminenableUser(userstatus, awsname).subscribe(res => {
        console.log(res);
        if (res == 1) {
          let users = {
            'records': {
              'userid': userstatus.userid,
              'isactive': '1',
            }
          };
          this.aws.adminupendis(users).subscribe(res => {
            if (res.status == 200) {
              this.shared.redirectTo(this.route.url);
            }
          })
        }
      })
    }
  }

  editUserDetails(userId){
    let userDetails = this.userdata.filter(users=>users.userid == userId)[0];
    this.aws.adminGetUsers(userDetails).subscribe(res=>{
      
        this.route.navigate(['settings/userRegister']);
      });
  }
}
