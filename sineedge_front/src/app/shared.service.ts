import { Injectable } from '@angular/core';
import { AuthenticationDetails, CognitoUser, CognitoUserPool } from 'amazon-cognito-identity-js';
import { Router } from "@angular/router";
import * as aws from 'aws-sdk';
import { Http, Headers, RequestOptions } from '@angular/http';
let apiUrl = 'http://localhost/sineedge/sparqapi/api/'
let currentuser: any = window.localStorage.getItem("Currentuser");
console.log(currentuser);
let poolData: any;

let userPool: any;

if (currentuser != '' && currentuser != null && currentuser == 1) {
  poolData = {
    UserPoolId: 'ap-south-1_qQ85yQZJO', // Your user pool id here
    ClientId: '2o5c3cs9k3als16nqhp3irh8rs' // Your client id here  
  };

} else if (currentuser != '' && currentuser != null && currentuser == 2) {
  poolData = {
    UserPoolId: "ap-south-1_hFiGyr1Gw", //  Your user pool id here
    ClientId: "6egsdssf0i7h2o9mscqgqbn788" // Your client id here

  };

} else {

}
console.log(poolData);

if (poolData !== undefined) {
  userPool = new CognitoUserPool(poolData);
}
@Injectable({
  providedIn: 'root'
})
export class SharedService {
  cognitoUser: any;
  jwttoken: any;
  constructor(public route: Router,public http:Http) {
    
      
    if (this.getAuthenticatedUser() !== '' && this.getAuthenticatedUser() !== undefined) {
      this.route.navigate(['/home']);
    } else {
      this.route.navigate(['/']);
    }

  }

/**
 * refresh session function 
 */
  getAuthenticatedUser() {
    if (userPool !== undefined) {
      this.cognitoUser = userPool.getCurrentUser();
    }
    let jwttoken = '';
    let session = '';
    if (this.cognitoUser != null) {
      this.cognitoUser.getSession(function (err, session) {
        if (err) {
          alert(err.message || JSON.stringify(err));
          return;
        }
        console.log('session validity: ' + session.isValid());
        jwttoken = session.getIdToken().getJwtToken();
      });
      //console.log()
     
        return jwttoken;
      
    }
  }

  getheaderssession() {
    if (userPool !== undefined) {
      this.cognitoUser = userPool.getCurrentUser();
      console.log(this.cognitoUser);
    }
    let jwttoken = '';
    let session = '';
    if (this.cognitoUser != null) {
      this.cognitoUser.getSession(function (err, session) {
        if (err) {
          alert(err.message || JSON.stringify(err));
          return;
        }
        console.log('session validity: ' + session.isValid());
        jwttoken = session;
      });
      //console.log()
     
        return jwttoken;
      
    }
  }

  headercofig(customeData){
    let session:any = this.getheaderssession() ||"";
    
    let headers = new Headers(
      { 
        'Content-Type':'application/json','Authorization':'sparqvenba2018','Token':session.getIdToken().getJwtToken()
      });
      return headers;
  }

  /**
   * Redirect Function 
   */
  redirectTo(uri) {
    this.route.navigateByUrl('/', {skipLocationChange: true}).then(() =>
    this.route.navigate([uri]));
  }

  /**
   * Get Roles
   */
  getroles(){
    let cogusers:any = this.getheaderssession();
    console.log(cogusers.idToken.payload.locale);
    let roles = {'userid':cogusers.idToken.payload.locale}; 
    let headers = this.headercofig('');
    return this.http.post(apiUrl+'getUsersDetails',roles,{headers:headers}).map(res=>res.json());
  }
}
