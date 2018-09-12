import { Injectable } from "@angular/core";
import {
  AuthenticationDetails,
  CognitoUserPool,
  CognitoUser,
  CognitoUserAttribute,
  ICognitoUserAttributeData,
  ISignUpResult,
  CognitoUserSession
} from "amazon-cognito-identity-js";
import { Observable } from "rxjs/Observable";
import "rxjs/add/operator/map";
import * as AWS from "aws-sdk";
import { LoginComponent } from "./session/login/login.component";

import { Http, Headers, RequestOptions } from '@angular/http';
import { HttpClient } from '@angular/common/http';
import 'rxjs/add/operator/map';

import { SharedService } from './shared.service';


let apiurl = 'localhost/sineedge/sparqapi/api/';
const sineedge_poolData = { 
  UserPoolId: "ap-south-1_y7dt3iEaX", //ap-south-1_qQ85yQZJO UserName :SPARQ_SINEEDGE_DEV
  ClientId: "291qt4smn5pql6o8cc2hi201lj" // ClientName: SINEEDGE_DEV_WEB
};
const sineedgedev_poolData = {
  UserPoolId: "ap-south-1_qQ85yQZJO", // UserName :SPARQ_SINEEDGE_DEV
  ClientId: "2o5c3cs9k3als16nqhp3irh8rs" // ClientName: SINEEDGE_DEV_WEB
}
const lender_poolData = {
  UserPoolId: "ap-south-1_hFiGyr1Gw", //  Username :SPARQ_LENDER_DEV
  ClientId: "6egsdssf0i7h2o9mscqgqbn788" // ClientName:LENDER_DEV_WEB
};
const vendor_poolData = {
  UserPoolId: "",
  ClientId: ""
}
const sineedgeUserPool = new CognitoUserPool(sineedge_poolData);
const lenderUserPool = new CognitoUserPool(lender_poolData);
const sineedgedevUserpool = new CognitoUserPool(sineedgedev_poolData);

/**
* Identity PoolID 
*/
const sineedgeIdentity = "ap-south-1:9a551eab-97cf-4991-b677-2f9bcd058961";//"ap-south-1:9a551eab-97cf-4991-b677-2f9bcd058961";
const lenderIdentity = "ap-south-1:ca22dabc-db59-4af5-9bb8-265f7ec95907";
const vendorIdenttiy = "";
// serviceProvider
apiurl = "http://localhost/sineedge/sparqapi/api/";
const currentdate = new Date().toJSON().slice(0,19).replace('T',' ');

@Injectable({
  providedIn: "root"
})


export class AwsService {

  mySecData: any;

  cognitoUser: any;
  jwttoken: any;
  cognitousers: any;
  localUserId:any = '';
  constructor(public http: Http, public RequestOptions: RequestOptions, public shared: SharedService) { }

  /**
   * Login Function
   * @param authenticationData inside of(email and password for login user)
   * By sriram
   */
  dologin(authenticationData) {
    //(authenticationData);
    const authenticationDetails = new AuthenticationDetails(authenticationData);
    let Newpassword = authenticationData.newpassword;
    let attributesData = [];
    const userData = {
      Username: authenticationData.Username, // User email id
      Pool: sineedgedevUserpool // user Pool ID
    };
    let cognitoUser = new CognitoUser(userData);
    return Observable.create(observer => {
      cognitoUser.authenticateUser(authenticationDetails, {
        newPasswordRequired: (userAttributes, requiredAttributes) => { // new password set 
          cognitoUser.completeNewPasswordChallenge(
            Newpassword,
            attributesData,
            {
              onSuccess: function (result) {
                observer.next(result);
                observer.complete();
              },
              onFailure: function (err) {
                //(err);
                observer.error(err);
                //LoginComponent.prototype.open();
              }
            }
          );
        },
        onSuccess: function (result) { // success user login
          // let accessToken = result.getAccessToken().getJwtToken();
          ////(result);
          window.localStorage.setItem('Currentuser', '1');
          observer.next(result);
          observer.complete();
        },
        onFailure: function (err) { // error user login

          alert(err.message);
          observer.error(err);
        }
      });
    });
  }
  /**
   * End of login function
   */

  /**
   * User Session validate
   */
  getAuthenticatedUser(): any {
    // gets the current user from the local storage
    this.cognitoUser = sineedgedevUserpool.getCurrentUser();
    //let sessions = '';

    let jwttoken = "";
    let session = "";
    if (this.cognitoUser != null) {
      this.cognitoUser.getSession(function (err, session) {
        if (err) {
          alert(err.message || JSON.stringify(err));
          return;
        }
        console.log("session validity: " + session.isValid());
        jwttoken = session;
        ////(jwttoken);
        AWS.config.region = "ap-south-1";
        AWS.config.credentials = new AWS.CognitoIdentityCredentials({
          IdentityPoolId: sineedgeIdentity, // for sineedge_DEV
          Logins: {
            "cognito-idp.ap-south-1.amazonaws.com/ap-south-1_qQ85yQZJO": session
              .getIdToken()
              .getJwtToken()
          }
          // NOTE: getSession must be called to authenticate user before calling getUserAttributes
        });
      });
      ////()



      return jwttoken;
    }
  }
  /**
   * End of function
   */
  getconfig() {
    let session = this.getAuthenticatedUser() || "";
    let config = "";
    config += AWS.config.region = "ap-south-1";
    config += AWS.config.credentials = new AWS.CognitoIdentityCredentials({
      IdentityPoolId: sineedgeIdentity, // for sineedge_DEV
      Logins: {
        "cognito-idp.ap-south-1.amazonaws.com/ap-south-1_qQ85yQZJO": session
          .getIdToken()
          .getJwtToken()
      }
      // NOTE: getSession must be called to authenticate user before calling getUserAttributes
    });
    return config;
  }

  getlocale(){
    let session:any = this.getAuthenticatedUser() || "";
    return session.idToken.payload.locale;
  }
  /**----------------------*/
  /**----------------------*/
  /**
   * User Details 
   */
  getUser() {
    // gets the current user from the local storage

    let currentUser = sineedgedevUserpool.getCurrentUser();
    //console.log(currentUser);
    return currentUser;
  }
  getuserdata() {
    let headers = this.shared.headercofig('');
    console.log(headers);
    let users = this.http.get(apiurl + 'getListOfUsers', { headers: headers }).map(res => res.json());
    console.log(users);
    return users;
  }
  /**
   * User Logout
   */
  logOut() {
    window.localStorage.removeItem("Currentuser");
    this.getUser().signOut();
    this.cognitoUser = null;
  }
  /**
   * User Change Password
   */
  changepassword(passData) {
    let session = this.getAuthenticatedUser() || "";
    console.log(session);
    this.getconfig();
    var params = {
      AccessToken: session.accessToken.jwtToken, /* required */
      PreviousPassword: passData.oldPassword, /* required */
      ProposedPassword: passData.newPassword /* required */
    };
    return Observable.create(observe => {
      let cognitoidentityserviceprovider = new AWS.CognitoIdentityServiceProvider();
      cognitoidentityserviceprovider.changePassword(params, function (err, data) {
        if (err) console.log(err, err.stack); // an error occurred
        console.log(data);
        observe.next(data);
        // successful response
      });
    })
  }

  /**
   * user function end
   */

  /**
   * admin User Create
   * @param userData refer to register components
   */
  register(userData) {
    let session = this.getAuthenticatedUser() || "";
    this.getconfig();
    let registeredData: any = "";
    let params: any;
    let userGroup = session.idToken.payload["cognito:groups"].filter(
      usergroup => usergroup == "ADMIN"
    )[0];
    // (userGroup);
    if (userGroup == "ADMIN") {
      if (userData.type.entity_type_id == 1) {
        params = {
          UserPoolId: sineedgedev_poolData.UserPoolId /* required */,
          Username: userData.email /* required */,
          DesiredDeliveryMediums: [
            "EMAIL"
            /* more items */
          ],
          // ForceAliasCreation: true || false,
          MessageAction: "SUPPRESS",
          TemporaryPassword: "temp1234",
          UserAttributes: [
            {
              Name: "email" /* required */,
              Value: userData.email
            },
            {
              Name: "phone_number" /* required */,
              Value: "+91" + userData.phone
            }
            /* more items */
          ]
        };
      } else if (userData.type.entity_type_id == 2) {
        params = {
          UserPoolId: lender_poolData.UserPoolId /* required */,
          Username: userData.email /* required */,
          DesiredDeliveryMediums: [
            "EMAIL"
            /* more items */
          ],
          // ForceAliasCreation: true || false,
          MessageAction: "SUPPRESS",
          TemporaryPassword: "temp1234",
          UserAttributes: [
            {
              Name: "email" /* required */,
              Value: userData.email
            },
            {
              Name: "phone_number" /* required */,
              Value: "+91" + userData.phone
            }
            /* more items */
          ]
        };
      }
      // .log(params);
      return Observable.create(observe => {
        let cognitoidentityserviceprovider = new AWS.CognitoIdentityServiceProvider();

        cognitoidentityserviceprovider.adminCreateUser(params, (
          err,
          data
        ) => {
          if (err) { alert(err.stack); }
          // an error occurred


          this.mySecData = data;
          AwsService.prototype.UserGroup(data, userData);
          observe.next(data);

          // successful response
        });
      });
    }
  }


  UserGroup(cognitodata, userData) {
    //(userData);

    let session = this.getAuthenticatedUser() || "";
    this.getconfig();

    //let cognitodata = "539bfefa-ae42-4bee-bf79-4b15d1a2af7f";
    if(userData.userid ==''){
    for(let role of userData.role){
      
    let params: any;
    if (userData.type.entity_type_id == 1) {

      params = {
        GroupName: role.value /* required */,
        UserPoolId: sineedgedev_poolData.UserPoolId,//"ap-south-1_y7dt3iEaX" /* required */,
        Username: cognitodata.User.Username //'539bfefa-ae42-4bee-bf79-4b15d1a2af7f' /* required */
      };

    } else if (userData.type.entity_type_id == 2) {
      params = {
        GroupName: role.value /* required */,
        UserPoolId: lender_poolData.UserPoolId,//"ap-south-1_y7dt3iEaX" /* required */,
        Username: cognitodata.User.Username //'539bfefa-ae42-4bee-bf79-4b15d1a2af7f' /* required */
      };


    }
    //(params);
    let cognitoidentityserviceprovider = new AWS.CognitoIdentityServiceProvider();

    cognitoidentityserviceprovider.adminAddUserToGroup(params, function (
      err,
      data
    ) {
      if (err) {
        alert(err.stack);
      }//(err, err.stack);
      // an error occurred
      else {//(data);

        return data;

      }


    });
    }
  }else{
    let params :any;
    console.log(userData);
    console.log(cognitodata);
    if (userData.fk_entity_id == 1) {

      params = {
        GroupName: cognitodata.value /* required */,
        UserPoolId: sineedgedev_poolData.UserPoolId,//"ap-south-1_y7dt3iEaX" /* required */,
        Username: userData.aws_name //'539bfefa-ae42-4bee-bf79-4b15d1a2af7f' /* required */
      };

    } else if (userData.fk_entity_id == 2) {
      params = {
        GroupName: cognitodata.value /* required */,
        UserPoolId: lender_poolData.UserPoolId,//"ap-south-1_y7dt3iEaX" /* required */,
        Username: userData.aws_name //'539bfefa-ae42-4bee-bf79-4b15d1a2af7f' /* required */
      };


    }
    //(params);
    let cognitoidentityserviceprovider = new AWS.CognitoIdentityServiceProvider();

    cognitoidentityserviceprovider.adminAddUserToGroup(params, function (
      err,
      data
    ) {
      if (err) {
        alert(err.stack);
      }//(err, err.stack);
      // an error occurred
      else {//(data);

       console.log(data);

      }


    });
  }

  }

  /**
   * AWS User Create Local DB
   * @param  cognitousers,users
   **/
  saveRecords(cognitousers, users) {
    
    let data: any = '';
    
    if (cognitousers != '' && cognitousers !== undefined) {
      //console.log(users);
      let aws_name :any;
      let updateby:any;
      let createdby:any;
      let createdon:any;
      let updateon:any;
      if(users.userid != null){
          aws_name = users.aws_name;
          updateby = this.getlocale();
          updateon = currentdate;
      }else{
        aws_name = cognitousers.User.Username;
        createdby =  this.getlocale();
        createdon = currentdate;
      }
     
      let formData = new FormData();
      console.log(users);
      
      let records:any = {
        "userid":users.userid,
        "aws_name": aws_name,
        "first_name": users.firstName,
        "last_name": users.lastName,
        "mobile_no": users.phone,
        "email": users.email,
        "alt_email":users.alt_email,
        "alt_mobile_no":users.alt_mobile_no,
        "addressline1":users.address1,
        "addressline2":users.address2,
        "addressline3":users.address3,
        "isactive":users.isactive,
        "fk_entity_id":users.type.entity_type_id,
        "fk_designation":users.designation.designation_id,
        "fk_city":users.city.city_id,
        "fk_state":users.state.state_id,
        "pincode":users.pincode,
        "profilepic":users.userpic.name,
        "fk_createdby":createdby,
        "fk_updatedby":updateby,
        "createdon":createdon,
        "updatedon":updateon,
      };
      let roles:any=[];
      for(var role of users.role){
        
      roles.push({ "user_role": role.value });
    }
    console.log(roles);
      formData.append('records',JSON.stringify(records));
      formData.append('roles',JSON.stringify(roles));
      formData.append('profilepic',users.userpic);
      //new Response(formData).text().then(console.log);
      //let headers = this.shared.headercofig('');
      let session:any = this.getAuthenticatedUser() ||"";
    
    let headers = new Headers(
      { 
        'Authorization':'sparqvenba2018','Token':session.getIdToken().getJwtToken()
      });
      
      //(request);
      if(users.userid !='' && users.userid !=null && users.userid !==undefined){
        return this.http.post(apiurl+'updateExistUser',formData,{headers:headers}).map(res=>res.json());
      }else{
      return this.http.post(apiurl + "saveNewUser", formData, { headers: headers }).map(res => res.json());
      }


    }

  }
  /**
 * admin User update 
 * @param username,clientid params 
 **/
  adminUpdateuser(user, cognitosdata) {
    let session = this.getAuthenticatedUser() || "";
    this.getconfig();

    //let cognitodata = "539bfefa-ae42-4bee-bf79-4b15d1a2af7f";
    let userGroup = session.idToken.payload["cognito:groups"].filter(
      usergroup => usergroup == "ADMIN"
    )[0];
    //cognitosdata = 7;

    if (userGroup == 'ADMIN') {
      var params = {
        UserAttributes: [ /* required */
          {
            Name: 'locale', /* required */
            Value: cognitosdata.toString()
          },
          /* more items */
        ],
        UserPoolId: sineedgedev_poolData.UserPoolId, /* required */
        Username: user.email /* required */
      };
      //console.log(params);
      return Observable.create(observe => {
        let cognitoidentityserviceprovider = new AWS.CognitoIdentityServiceProvider();

        cognitoidentityserviceprovider.adminUpdateUserAttributes(params, function (err, data) {
          if (err) //(err, err.stack);
            console.log(data); // an error occurred
          observe.next(data);       // successful response
        });
      });
    }

  }
  /**
   * Admin enable user
   * @param userdata 
   * @param awsName 
   */
  adminenableUser(userdata, awsName) {
    let session = this.getAuthenticatedUser() || "";
    this.getconfig();
    let userGroup = session.idToken.payload["cognito:groups"].filter(
      usergroup => usergroup == "ADMIN"
    )[0];
    //cognitosdata = 7;
    let params: any;
    if (userGroup == 'ADMIN') {
      console.log(userdata);
      if (userdata.fk_entity_id == 1) {
        params = {
          UserPoolId: sineedgedev_poolData.UserPoolId, /* required */
          Username: awsName /* required */
        };
      } else if (userdata.fk_entity_id == 2) {
        params = {
          UserPoolId: lender_poolData.UserPoolId, /* required */
          Username: awsName /* required */
        };
      }
      console.log(params);
      return Observable.create(observe => {
        let cognitoidentityserviceprovider = new AWS.CognitoIdentityServiceProvider();
        cognitoidentityserviceprovider.adminEnableUser(params, function (err, data) {
          if (err) console.log(err, err.stack); // an error occurred
          observe.next("1");         // successful response
        });
      });
    }
  }
  /**
   * admin Disable user
   * @param userdata 
   * @param awsName 
   */
  admindisabelUser(userdata, awsName) {
    let session = this.getAuthenticatedUser() || "";
    this.getconfig();
    let userGroup = session.idToken.payload["cognito:groups"].filter(
      usergroup => usergroup == "ADMIN"
    )[0];
    //cognitosdata = 7;
    let params: any;
    if (userGroup == 'ADMIN') {
      console.log(userdata);
      if (userdata.fk_entity_id == 1) {
        params = {
          UserPoolId: sineedgedev_poolData.UserPoolId, /* required */
          Username: awsName /* required */
        };
      } else if (userdata.fk_entity_id == 2) {
        params = {
          UserPoolId: lender_poolData.UserPoolId, /* required */
          Username: awsName /* required */
        };
      }
      console.log(params);
      return Observable.create(observe => {
        let cognitoidentityserviceprovider = new AWS.CognitoIdentityServiceProvider();
        cognitoidentityserviceprovider.adminDisableUser(params, function (err, data) {
          if (err) console.log(err, err.stack); // an error occurred
          observe.next("0");         // successful response
        });
      });
    }
  }
  /**
   * Admin Local Update
   * @param records 
   */
  adminupendis(records){
    let headers = this.shared.headercofig('');
    console.log(headers);
    let users = this.http.post(apiurl + 'updateExistUser',JSON.stringify(records), { headers: headers }).map(res => res.json());
    console.log(users);
    return users;
  }
  /**
   *  Admin Create User End 
  **/ 
/************************************************************************************ */
  /**
   * Admin Upadte users
   */

  adminGetUsers(userId){
    this.localUserId = userId;
    
    
        
    return Observable.create(observe=>{ 
      observe.next(this.localUserId);
    })
  }
  
  adminchangeData(userData,changeusers){
    console.log(userData);
    console.log(changeusers);
    let session = this.getAuthenticatedUser() || "";
    this.getconfig();
    let registeredData: any = "";
    let params:any='';
    let userGroup = session.idToken.payload["cognito:groups"].filter(
      usergroup => usergroup == "ADMIN"
    )[0];
    // (userGroup);
    if (userGroup == "ADMIN") {
     if (userData.fk_entity_id == 1) {
        params = {
          UserPoolId: sineedgedev_poolData.UserPoolId /* required */,
          Username: userData.email,//userData.email /* required */,
          
          // ForceAliasCreation: true || false,
          
          UserAttributes: [
            {
              Name: "email" /* required */,
              Value: changeusers.email,//userData.email
            },
            {
              Name: "phone_number" /* required */,
              Value: "+91"+ changeusers.phone
            }
            /* more items */
          ]
        };
      } else if (userData.fk_entity_id == 2) {
        params = {
          UserPoolId: lender_poolData.UserPoolId /* required */,
          Username: changeusers.email /* required */,
          
          UserAttributes: [
            {
              Name: "email" /* required */,
              Value: changeusers.email
            },
            {
              Name: "phone_number" /* required */,
              Value: "+91" + changeusers.phone
            }
            /* more items */
          ]
        };
      }
      return Observable.create(observe=>{
        let cognitoidentityserviceprovider = new AWS.CognitoIdentityServiceProvider();
        cognitoidentityserviceprovider.adminUpdateUserAttributes(params, function(err, data) {
          if (err) console.log(err, err.stack); // an error occurred
          observe.next(data);         // successful response
        });
      })
    }
  }
adminremoveGroup(roles,users){
  console.log(roles);
  console.log(users);
  if(users !==undefined){
    
  let session = this.getAuthenticatedUser() ||"";
  this.getconfig();
  var params = {
    GroupName: roles.value, /* required */
    UserPoolId: sineedgedev_poolData.UserPoolId, /* required */
    Username: users.aws_name//'2c64866e-e96f-453b-903f-2b6f831688af' /* required */
  };
  let cognitoidentityserviceprovider = new AWS.CognitoIdentityServiceProvider();
  cognitoidentityserviceprovider.adminRemoveUserFromGroup(params, function(err, data) {
    if (err) console.log(err, err.stack); // an error occurred
    else     console.log(data);           // successful response
  });
}
}
/************************************************************************************ */
  /**
  *  user forgot password 
  * @parms ClientId , Username(Email)
  */

  userforgotpass(auth) {
    ////(auth);
    const userData = {
      Username: auth.Username,
      Pool: sineedgedevUserpool
    };
    let cognitoUser = new CognitoUser(userData);
    return Observable.create(observe => {
      cognitoUser.forgotPassword({
        onSuccess: function (data) {
          // successfully initiated reset password request
          //('CodeDeliveryData from forgotPassword: ' + data);
          observe.next(data);
        },
        onFailure: function (err) {
          alert(err.message || JSON.stringify(err));
        },
        //Optional automatic callback
        inputVerificationCode: function (data) {
          //('Code sent to: ' + data);
          var verificationCode = prompt('Please input verification code ', '');
          var newPassword = prompt('Enter new password ', '');
          cognitoUser.confirmPassword(verificationCode, newPassword, {
            onSuccess() {
              //('Password confirmed!');
            },
            onFailure(err) {
              //('Password not confirmed!');
            }
          });
        }
      });
    });


  }

  /**
   * Get Local Data
   */

  entityType(){
    let headers = this.shared.headercofig('');
    let master_name = {'master_name':'ENTITYTYPE'};
    return this.http.post(apiurl+'getListOfMaster',master_name,{headers:headers}).map(res=>res.json());
  }
  City(){
    let headers = this.shared.headercofig('');
    let master_name = {'master_name':'CITY'};
    return this.http.post(apiurl+'getListOfMaster',master_name,{headers:headers}).map(res=>res.json());
  }
  State(){
    let headers = this.shared.headercofig('');
    let master_name = {'master_name':'STATE'};
    return this.http.post(apiurl+'getListOfMaster',master_name,{headers:headers}).map(res=>res.json());
  }
  designation(){
    let headers = this.shared.headercofig('');
    let master_name = {'master_name':'DESIGNATION'};
    return this.http.post(apiurl+'getListOfMaster',master_name,{headers:headers}).map(res=>res.json());
  }

}
