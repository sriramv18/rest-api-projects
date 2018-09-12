import { Component,OnInit } from '@angular/core';
import {TranslateService} from 'ng2-translate/ng2-translate';
import { SharedService } from './shared.service';
@Component({
  selector: 'app-root',
  template: '<router-outlet></router-outlet>'
})

export class AppComponent implements OnInit {
  
  
  constructor(translate: TranslateService,public shared:SharedService) {
    translate.addLangs(['en', 'fr']);
    translate.setDefaultLang('en');
    //new aws_demo();
    //aws();
    this.shared;
    const browserLang: string = translate.getBrowserLang();
    translate.use(browserLang.match(/en|fr/) ? browserLang : 'en');
    
  }
ngOnInit(){
  
  
}   


}
