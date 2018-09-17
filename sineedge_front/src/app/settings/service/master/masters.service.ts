import { Injectable } from '@angular/core';
import { Observable }   from 'rxjs/Observable';//for Datatables
import { Http, Response } from '@angular/http';
import { HttpHeaders } from '@angular/common/http';

import 'rxjs/add/operator/map';//for Datatables
import 'rxjs/add/operator/catch';
import 'rxjs/add/operator/toPromise';

/** Service  */
import { SharedService } from '../../../shared.service';

/** Model  */
import { PdAllocationType, PdLocationApproach ,PdStatus ,PdType } from '../../model/pd';
import { Branch } from '../../model/branch';
import { States } from '../../model/states';
import { City } from '../../model/city';
import { Uom } from '../../model/uom';
import { Company } from '../../model/company';
import { Activity } from '../../model/activity';
import { Title } from '../../model/title';
import { ProductMaster } from '../../model/product-master';
import { SubProductMaster } from '../../model/sub-product-master';
import { IndustryClassification } from '../../model/industry_classification';
import { Regions } from '../../model/regions';
import { Designation } from '../../model/designation';
import { RelationShip } from '../../model/relation-ship';
import { CustomerBehaviour } from '../../model/customer-behaviour';
import { CommentsOnLocality } from '../../model/comments-on-locality';
import { CustomerSegment } from '../../model/customer-segment';
import { Frequency } from '../../model/frequency';
import { LenderHierarchy } from '../../model/lender-hierarchy';
import { MembersOccupation } from '../../model/members-occupation';
import { EntityType } from '../../model/entity-type';
//import {} from '../model/states';



export interface Master {
  master_id:number;
  master_name:string;
  constant_name:string;
}

// const httpOptions = {
//   headers: new HttpHeaders({
//     'Content-Type':  'application/json',
//     'Authorization': 'sparqvenba2018'
//   })
// };


@Injectable()

export class MastersService {
  
  // private storeUrl = 'http://localhost/SineEdge/sparqapi/api/saveMaster';
  // private branchUrl = 'http://localhost/SineEdge/sparqapi/api/getListOfBranches';
  // private serviceUrl = 'http://localhost/SineEdge/sparqapi/api/getListOfMaster';

  private storeUrl = 'http://localhost/sparqapi/api/saveMaster';
  private serviceUrl = 'http://localhost/sparqapi/api/getListOfMaster';
  
  
  //constructor(private http: HttpClient) { }
  constructor(private http: Http,public shared:SharedService) { }
  headers:any = this.shared.headercofig('');
  
  /** TO Add Data using API Call */
  addMasterDetails(Records: any,MasterName:string): Observable<any> {
    var ArrayData = {
              "master_name":MasterName,
              "records": Records
            }
    //var data = this.http.post<any>(this.storeUrl,ArrayData,httpOptions);
    var data = this.http.post(this.storeUrl,ArrayData,{headers:this.headers});
    console.log(data);
    return data;
  }

  /** TO Edit Data using API Call */
  editMasterDetails(Records: any,MasterName:string):  Observable<any> {
    console.log('Edited Data IN Service Argument ONLY',ArrayData);
    var ArrayData = {
      "master_name":MasterName,
      "records": Records
    }
    console.log('Edited Data IN Service Array ONLY',ArrayData);
    //var data = this.http.post<any>(this.storeUrl,ArrayData,httpOptions);
    var data = this.http.post(this.storeUrl,ArrayData,{headers:this.headers});
    return data;
  }
  
  /**To Inactive Array Data using API Call */
  deleteMasterDetails(id: number,MasterName:string): Observable<any> {
    console.log(' DeletedID  IN Service Argument ONLY',id);
    var ArrayData = {
      "master_name":MasterName,
      "records": {branch_id:id,isactive:0}
    }
    console.log('DeletedID IN Service Array',ArrayData);
    var data = this.http.post(this.storeUrl,ArrayData,{headers:this.headers});
    //var data = this.http.post<any>(this.storeUrl,ArrayData,httpOptions);
    return data;
  }


  /** Get All Branch Data using API call With master Keyword */
  // getAllBranch(): Observable<Branch[]> {
    
  //   return this.http.get(this.branchUrl,httpOptions)
  //                   .map(this.extractData)
  //                   .catch(this.handleError);
  
  // }
  getAllBranch(): Observable<Branch[]> {
    
    let tab = {'master_name':'BRANCH'};
    return this.http.post(this.serviceUrl,tab,{headers:this.headers})
                    .map(this.extractData)
                    .catch(this.handleError);
  
  }


  getAllMasterData(): Observable<Master[]> {
    var CityArr  = {
      "master_name":"LISTOFMASTERS",
                  }
    return this.http.post(this.serviceUrl,CityArr,{headers:this.headers})
               .map(this.extractData)
               .catch(this.handleError);
  }

  /** Get All Branch Data using API call With master Keyword */
  getAllCityData(): Observable<City[]> {
    var CityArr  = {
      "master_name":"CITY",
                  }
    //return this.http.post(this.serviceUrl,CityArr,httpOptions)
    return this.http.post(this.serviceUrl,CityArr,{headers:this.headers})
               .map(this.extractData)
               .catch(this.handleError);
  }

  /** Get All Uom Data using API call With master Keyword */
  getAllUom(): Observable<Uom[]> {
            
    var UomArr  = {
                     "master_name":"UOM",
                  }
    return this.http.post(this.serviceUrl,UomArr,{headers:this.headers})
    .map(this.extractData)
    .catch(this.handleError);
  
  }

  /** Get All Branch Data using API call With master Keyword */
  getAllCompany(): Observable<Company[]> {
    var CompanyArr  = {
      "master_name":"COMPANY",
                  }
    return this.http.post(this.serviceUrl,CompanyArr,{headers:this.headers})
               .map(this.extractData)
               .catch(this.handleError);
  }

  /** Get All Activity Data using API call With master Keyword */
  getAllActivity(): Observable<Activity[]> {
    
    var ActivityArr  = {
                    "master_name":"TYPEOFACTIVITY",
                  }
    return this.http.post(this.serviceUrl,ActivityArr,{headers:this.headers})
    .map(this.extractData)
    .catch(this.handleError);
  
  }
   /** Get All Title Data using API call With master Keyword */
   getAllTitle(): Observable<Title[]> {
          
    var TitleArr  = {
                     "master_name":"TITLES",
                  }
    return this.http.post(this.serviceUrl, TitleArr,{headers:this.headers})
    .map(this.extractData)
    .catch(this.handleError);
  
  }
   /** Get All SubProductMaster Data using API call With master Keyword */
   getAllSubProductMaster(): Observable<SubProductMaster[]> {
          
    var SubProductMasterArr  = {
                     "master_name":"SUBPRODUCTS"
                     
                  }
    return this.http.post(this.serviceUrl, SubProductMasterArr,{headers:this.headers})
    .map(this.extractData)
    .catch(this.handleError);
  
  }
   /** Get All Region Data using API call With master Keyword */
   getAllRegion(): Observable<Regions[]> {
    
    var RegionArr  = {
                    "master_name":"REGIONS",
                  }
    return this.http.post(this.serviceUrl,RegionArr,{headers:this.headers})
    .map(this.extractData)
    .catch(this.handleError);
  
  }

  /** Get All State Data using API call With master Keyword */
  getAllState(): Observable<States[]> {
    
    var StateArr  = {
                    "master_name":"STATE",
                  }
    return this.http.post(this.serviceUrl,StateArr,{headers:this.headers})
    .map(this.extractData)
    .catch(this.handleError);
  
  }
  /** Get All RelationShip Data using API call With master Keyword */
  getAllRelationShip(): Observable<RelationShip[]> {
          
    var RelationShipArr  = {
                     "master_name":"RELATIONSHIPS",
                  }
    return this.http.post(this.serviceUrl, RelationShipArr,{headers:this.headers})
    .map(this.extractData)
    .catch(this.handleError);
  
  }

  /** Get All City Data using API call With master Keyword */
  getAllCity(): Observable<City[]> {
    
    var CityArr  = {
                    "master_name":"CITY",
                  }
    return this.http.post(this.serviceUrl,CityArr,{headers:this.headers})
    .map(this.extractData)
    .catch(this.handleError);
  
  }

  /** Get All CommentsOnLocality Data using API call With master Keyword */
  getAllCommentsOnLocality(): Observable<CommentsOnLocality[]> {
    
    var CommentsOnLocalityArr  = {
                 "master_name":"COMMENTSONLOCALITY",
                  }
    return this.http.post(this.serviceUrl,CommentsOnLocalityArr,{headers:this.headers})
    .map(this.extractData)
    .catch(this.handleError);
  
  }

  /** Get All CustomerBehaviour Data using API call With master Keyword */
  getAllCustomerBehaviour(): Observable<CustomerBehaviour[]> {
    
    var CustomerBehaviourArr  = {
                 "master_name":"CUSTOMERBEHAVIOUR",
                  }
    return this.http.post(this.serviceUrl,CustomerBehaviourArr,{headers:this.headers})
    .map(this.extractData)
    .catch(this.handleError);
  
  }

  /** Get All CustomerSegment Data using API call With master Keyword */
  getAllCustomerSegment(): Observable<CustomerSegment[]> {
    
    var CustomerSegmentArr  = {
                 "master_name":"CUSTOMERSEGMENT",
                  }
    return this.http.post(this.serviceUrl,CustomerSegmentArr,{headers:this.headers})
    .map(this.extractData)
    .catch(this.handleError);
  
  }

  /** Get All Designation Data using API call With master Keyword */
  getAllDesignation(): Observable<Designation[]> {
    
    var DesignationArr  = {
                 "master_name":"DESIGNATION",
                  }
    return this.http.post(this.serviceUrl,DesignationArr,{headers:this.headers})
    .map(this.extractData)
    .catch(this.handleError);
  
  }
/** Get All Frequency Data using API call With master Keyword */
getAllFrequency(): Observable<Frequency[]> {
    
  var FrequencyArr  = {
                  "master_name":"FREQUENCY",
                }
  return this.http.post(this.serviceUrl,FrequencyArr,{headers:this.headers})
  .map(this.extractData)
  .catch(this.handleError);

}

/** Get All IndustryClassification Data using API call With master Keyword */
getAllIndustryClassification(): Observable<IndustryClassification[]> {
      
  var IndustryClassificationArr  = {
                   "master_name":"INDUSTRYCLASSIFICATION",
                }
  return this.http.post(this.serviceUrl,IndustryClassificationArr,{headers:this.headers})
  .map(this.extractData)
  .catch(this.handleError);

}

  /** Get All LenderHierarchy Data using API call With master Keyword */
  getAllLenderHierarchy(): Observable<LenderHierarchy[]> {
    
    var LenderHierarchyArr  = {
                    "master_name":"LENDERHIERARCHY",
                  }
    return this.http.post(this.serviceUrl,LenderHierarchyArr,{headers:this.headers})
    .map(this.extractData)
    .catch(this.handleError);
  
  }

   /** Get All   MembersOccupation Data using API call With master Keyword */
   getAllMembersOccupation(): Observable<MembersOccupation[]> {
        
    var   MembersOccupationArr  = {
                     "master_name":"OCCUPATIONMEMBERS",
                  }
    return this.http.post(this.serviceUrl, MembersOccupationArr,{headers:this.headers})
    .map(this.extractData)
    .catch(this.handleError);
  
  }

  getAllProduct(): Observable<ProductMaster[]> {
    
    var ProdArr = {
                    "master_name":"PRODUCTS"
                  }
    return this.http.post(this.serviceUrl,ProdArr,{headers:this.headers})
    .map(this.extractData)
    .catch(this.handleError);

  }

    /** Get All   MembersOccupation Data using API call With master Keyword */
    getAllPDAllocationType(): Observable<PdAllocationType[]> {
        
      var   PDAllocationTypeArr  = {
                       "master_name":"PDALLOCATIONTYPE",
                    }
      return this.http.post(this.serviceUrl,  PDAllocationTypeArr,{headers:this.headers})
      .map(this.extractData)
      .catch(this.handleError);
    
    }

          /** Get AllPDLocationApproach Data using API call With master Keyword */
          getAllPDLocationApproach(): Observable<PdLocationApproach[]> {
      
            var   MembersOccupationArr  = {
                             "master_name":"PDLOCATIONAPPROACH",
                          }
            return this.http.post(this.serviceUrl, MembersOccupationArr,{headers:this.headers})
            .map(this.extractData)
            .catch(this.handleError);
          
          }

                /** Get All   MembersOccupation Data using API call With master Keyword */
    getAllPDStatus(): Observable<PdStatus[]> {
      
      var   MembersOccupationArr  = {
                       "master_name":"PDSTATUS",
                    }
      return this.http.post(this.serviceUrl,MembersOccupationArr,{headers:this.headers})
      .map(this.extractData)
      .catch(this.handleError);
    
    }

    /** Get All   MembersOccupation Data using API call With master Keyword */
    getAllPDType(): Observable<PdType[]> {
      
      var   MembersOccupationArr  = {
                       "master_name":"PDTYPE",
                    }
      return this.http.post(this.serviceUrl, MembersOccupationArr,{headers:this.headers})
      .map(this.extractData)
      .catch(this.handleError);
    
    }
  
    /** Get All EntityType Data using API call With master Keyword */
  getAllEntityType(): Observable<EntityType[]> {
    
    var EntityTypeArr  = {
                    "master_name":"ENTITYTYPE",
                  }
    return this.http.post(this.serviceUrl,EntityTypeArr,{headers:this.headers})
    .map(this.extractData)
    .catch(this.handleError);
  
  }

  /** Using Above .map() Method. We check the Response's array Status and return to the component */
  // private extractData(res : Response) {
  //   console.log('extractData',res);
  //    if (res['dataStatus'] === true) {
  //      let Records = res['records'];
  //      return Records; 
  //   }
  //   else{
  //     return [];   // return empty array if there is no data
  //   }
  // }

  private extractData(res : Response) {
    
    let Response = res['_body'];
        Response = JSON.parse(Response);

    return Response['dataStatus'] === true 
                                 ? Response['records'] 
                                 : []; 

    /* Checking Data Status is true or false., 
       TRUE means Return Arraydata 
       FALSE means Return empty array.
    */

    }
    
  


  // private parseData(Response) {
  // //console.log('parseData called',Response);
  //   if(Response.dataStatus == true){
  //     console.log('true part',Response.records);
  //     return Response.records;
  //   }
  //   else{
  //     return Response;
  //   }
  // }

  
  private handleError(error: any): Promise<any> {
    console.error('An error occurred', error);
    return Promise.reject(error.message || error);
  }

 
}