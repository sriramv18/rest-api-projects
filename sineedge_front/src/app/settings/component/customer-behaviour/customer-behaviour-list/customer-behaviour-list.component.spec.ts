import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CustomerBehaviourListComponent } from './customer-behaviour-list.component';

describe('CustomerBehaviourListComponent', () => {
  let component: CustomerBehaviourListComponent;
  let fixture: ComponentFixture<CustomerBehaviourListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CustomerBehaviourListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CustomerBehaviourListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
