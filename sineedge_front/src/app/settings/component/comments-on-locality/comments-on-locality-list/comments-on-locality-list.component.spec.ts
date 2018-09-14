import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { CommentsOnLocalityListComponent } from './comments-on-locality-list.component';

describe('CommentsOnLocalityListComponent', () => {
  let component: CommentsOnLocalityListComponent;
  let fixture: ComponentFixture<CommentsOnLocalityListComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ CommentsOnLocalityListComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(CommentsOnLocalityListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
