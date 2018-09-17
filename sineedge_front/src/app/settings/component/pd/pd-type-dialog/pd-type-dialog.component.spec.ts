import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PdTypeDialogComponent } from './pd-type-dialog.component';

describe('PdTypeDialogComponent', () => {
  let component: PdTypeDialogComponent;
  let fixture: ComponentFixture<PdTypeDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PdTypeDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PdTypeDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
