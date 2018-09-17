import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { SubProductDialogComponent } from './sub-product-dialog.component';

describe('SubProductDialogComponent', () => {
  let component: SubProductDialogComponent;
  let fixture: ComponentFixture<SubProductDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SubProductDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SubProductDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
