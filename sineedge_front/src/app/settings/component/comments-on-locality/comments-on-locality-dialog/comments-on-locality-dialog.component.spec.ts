import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CommentsOnLocalityDialogComponent } from './comments-on-locality-dialog.component';

describe('CommentsOnLocalityDialogComponent', () => {
  let component: CommentsOnLocalityDialogComponent;
  let fixture: ComponentFixture<CommentsOnLocalityDialogComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CommentsOnLocalityDialogComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CommentsOnLocalityDialogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
