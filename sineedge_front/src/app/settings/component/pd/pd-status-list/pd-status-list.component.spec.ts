import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PdStatusListComponent } from './pd-status-list.component';

describe('PdStatusListComponent', () => {
  let component: PdStatusListComponent;
  let fixture: ComponentFixture<PdStatusListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PdStatusListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PdStatusListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
