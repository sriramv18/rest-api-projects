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
let apiUrl = "http://localhost:8080/ApolloSC/api/";

const lender_poolData = {
  UserPoolId: "ap-south-1_bVF08ztrS", //  Your user pool id here
  ClientId: "2aqnppt0nb3kqbskpuiv8hi2t9" // Your client id here
};


const lenderUserPool =  new CognitoUserPool(lender_poolData);
@Injectable({
  providedIn: "root"
})
export class AwsLenderService {
  cognitoUser: any;
  jwttoken: any;
  cognitousers: any;
  constructor() {}

  /**
   * Login Function
   * @param authenticationData inside of(email and password for login user)
   * By sriram
   */
  dologin(authenticationData) {
    console.log(authenticationData);

    const authenticationDetails = new AuthenticationDetails(authenticationData);
    let Newpassword = "12345678";//authenticationData.newpassword;
    let attributesData = [];
    
    const userData = {
      Username: authenticationData.Username,
      Pool: lenderUserPool
    };
    const cognitoUser = new CognitoUser(userData);

    return Observable.create(observer => {
      cognitoUser.authenticateUser(authenticationDetails, {
        newPasswordRequired: (userAttributes, requiredAttributes) => {
          cognitoUser.completeNewPasswordChallenge(
            Newpassword,
            attributesData,
            {
              onSuccess: function(result) {
                observer.next(result);
                observer.complete();
              },
              onFailure: function(err) {
                console.log(err);
                observer.error(err);
                //LoginComponent.prototype.open();
              }
            }
          );
        },
        onSuccess: function(result) {
          // let accessToken = result.getAccessToken().getJwtToken();
          //console.log(result);
          window.localStorage.setItem('Currentuser','2');
          observer.next(result);
          observer.complete();
        },
        onFailure: function(err) {
          
          alert(err.message);
          observer.error(err);
        }
      });
    });
  }
  /**
   * End of login function
   */
  getUser() {
    // gets the current user from the local storage
    return lenderUserPool.getCurrentUser();
  }

  logOut() {
    window.localStorage.removeItem("Currentuser");
    this.getUser().signOut();
    this.cognitoUser = null;
  }

  /**
   * User Created for Admin
   * @param userDetails
   */
  getAuthenticatedUser(): any {
    // gets the current user from the local storage
    this.cognitoUser = lenderUserPool.getCurrentUser();
    //let sessions = '';

    let jwttoken = "";
    let session = "";
    if (this.cognitoUser != null) {
      this.cognitoUser.getSession(function(err, session) {
        if (err) {
          alert(err.message || JSON.stringify(err));
          return;
        }
        console.log("session validity: " + session.isValid());
        // this.session  = ;
        // console.log(this.session);
        //this.checkuserstatus(session);
        jwttoken = session;
        //console.log(jwttoken);
        AWS.config.region = "ap-south-1";
        AWS.config.credentials = new AWS.CognitoIdentityCredentials({
          IdentityPoolId: "ap-south-1:2ab4b493-f99f-4a06-9621-349197e36a5d",
          Logins: {
            "cognito-idp.ap-south-1.amazonaws.com/ap-south-1_y7dt3iEaX": session
              .getIdToken()
              .getJwtToken()
          }
          // NOTE: getSession must be called to authenticate user before calling getUserAttributes
        });
      });
      //console.log()

      //console.log("1");

      return jwttoken;
    }
  }
  /**
   * New admin User Create
   * @param userData refer to register components
   */
  // register(userData) {
  //   let session = this.getAuthenticatedUser() || "";
  //   let localdata: any;

  //   // let idToken = session.idToken;
  //   // console.log(idToken);return false;
  //   console.log(session);

  //   AWS.config.region = "ap-south-1";
  //   AWS.config.credentials = new AWS.CognitoIdentityCredentials({
  //     IdentityPoolId: "ap-south-1:2ab4b493-f99f-4a06-9621-349197e36a5d",
  //     Logins: {
  //       "cognito-idp.ap-south-1.amazonaws.com/ap-south-1_y7dt3iEaX": session
  //         .getIdToken()
  //         .getJwtToken()
  //     }
  //   });
  //   let params:any;
  //   let userGroup = session.idToken.payload["cognito:groups"].filter(
  //     usergroup => usergroup == "ADMIN"
  //   )[0];
  //   // console.log(userGroup);
  //   if (userGroup == "ADMIN") {
  //     if(userData.type.value ==1){
  //     params = {
  //       UserPoolId: lender_poolData.UserPoolId /* required */,
  //       Username: userData.email /* required */,
  //        DesiredDeliveryMediums: [
  //         "EMAIL"
  //         /* more items */
  //       ],
  //       // ForceAliasCreation: true || false,
  //       MessageAction: "SUPPRESS",
  //       TemporaryPassword: "temp1234",
  //       UserAttributes: [
  //         {
  //           Name: "email" /* required */,
  //           Value: userData.email
  //         },
  //         {
  //           Name: "phone_number" /* required */,
  //           Value: "+91" + userData.phone
  //         }
  //         /* more items */
  //       ]
  //     };
  //   }else if(userData.type.value ==2){
  //     params = {
  //       UserPoolId: lender_poolData.UserPoolId /* required */,
  //       Username: userData.email /* required */,
  //       DesiredDeliveryMediums: [
  //         "EMAIL"
  //         /* more items */
  //       ],
  //       // ForceAliasCreation: true || false,
  //       MessageAction: "SUPPRESS",
  //       TemporaryPassword: "temp1234",
  //       UserAttributes: [
  //         {
  //           Name: "email" /* required */,
  //           Value: userData.email
  //         },
  //         {
  //           Name: "phone_number" /* required */,
  //           Value: "+91" + userData.phone
  //         }
  //         /* more items */
  //       ]
  //     };
  //   }
  //   console.log(params);
  //     let cognitoidentityserviceprovider = new AWS.CognitoIdentityServiceProvider();
  //     cognitoidentityserviceprovider.adminCreateUser(params, function(
  //       err,
  //       data
  //     ) {
  //       if (err) alert(err.stack);
  //       // an error occurred
  //       else {
  //         console.log(data);
  //         //localdata = data;
  //         AwsLenderService.prototype.UserGroup(data, userData);
  //       }
  //       // successful response
  //     });
  //     //console.log(localdata);
  //   }
  // }
  // UserGroup(cognitodata, userData) {
  //   console.log(userData);

  //   let session = this.getAuthenticatedUser() || "";

  //   AWS.config.region = "ap-south-1";
  //   AWS.config.credentials = new AWS.CognitoIdentityCredentials({
  //     IdentityPoolId: "ap-south-1:2ab4b493-f99f-4a06-9621-349197e36a5d",
  //     Logins: {
  //       "cognito-idp.ap-south-1.amazonaws.com/ap-south-1_y7dt3iEaX": session
  //         .getIdToken()
  //         .getJwtToken()
  //     }
  //   });
  //   //let cognitodata = "539bfefa-ae42-4bee-bf79-4b15d1a2af7f";
  //   let userGroup = session.idToken.payload["cognito:groups"].filter(
  //     usergroup => usergroup == "ADMIN"
  //   )[0];
  //   console.log(userGroup);
  //   // if (userGroup == "ADMIN"){
  //   //console.log(localdata);
  //   let params:any;
  //   if(userData.type.value == 1){
      
  //   params = {
  //     GroupName: userData.role.value /* required */,
  //     UserPoolId: lender_poolData.UserPoolId,//"ap-south-1_y7dt3iEaX" /* required */,
  //     Username: cognitodata.User.Username //'539bfefa-ae42-4bee-bf79-4b15d1a2af7f' /* required */
  //   };
   
  // }else if(userData.type.value ==2){
  //    params = {
  //     GroupName: userData.role.value /* required */,
  //     UserPoolId: lender_poolData.UserPoolId,//"ap-south-1_y7dt3iEaX" /* required */,
  //     Username: cognitodata.User.Username //'539bfefa-ae42-4bee-bf79-4b15d1a2af7f' /* required */
  //   };
    
    
  // }
  // console.log(params);
  //   let cognitoidentityserviceprovider = new AWS.CognitoIdentityServiceProvider();
  //   cognitoidentityserviceprovider.adminAddUserToGroup(params, function(
  //     err,
  //     data
  //   ) {
  //     if (err) console.log(err, err.stack);
  //     // an error occurred
  //     else console.log(data); // successful response
  //   });
  // }

  // /**
  //  * Admin Get Users
  //  */
  // adminGetuser() {
  //   let session = this.getAuthenticatedUser() || "";
  //   let userGroup = session.idToken.payload["cognito:groups"].filter(
  //     usergroup => usergroup == "ADMIN"
  //   )[0];
  //   console.log(userGroup);
  //   if (userGroup == "ADMIN") {
  //     var params = {
  //       UserPoolId: lender_poolData.UserPoolId /* required */
  //     };
  //     let cognitoidentityserviceprovider = new AWS.CognitoIdentityServiceProvider();
  //     cognitoidentityserviceprovider.listUsers(params, function(err, data) {
  //       if (err) console.log(err, err.stack);
  //       // an error occurred
  //       else console.log(data); // successful response
  //     });
  //   }
  // }
}
