import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PdLocationApproachDialogComponent } from './pd-location-approach-dialog.component';

describe('PdLocationApproachDialogComponent', () => {
  let component: PdLocationApproachDialogComponent;
  let fixture: ComponentFixture<PdLocationApproachDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PdLocationApproachDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PdLocationApproachDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
