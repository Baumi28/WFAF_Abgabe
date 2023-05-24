import {Component, OnInit} from '@angular/core';
import {Entry, Padlet} from '../shared/padlet';
import {PadletAppService} from "../shared/padlet-app.service";
import {ActivatedRoute, Router} from "@angular/router";
import {ToastrService} from "ngx-toastr";
import {AuthenticationService} from "../shared/authentication.service";
import {Comment} from "../shared/comment";
import {Rating} from "../shared/rating";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {catchError, retry} from "rxjs";

//import * as console from "console";


@Component({
  selector: 'bs-padlet-details',
  templateUrl: './padlet-details.component.html',
  styles: []
})
export class PadletDetailsComponent implements OnInit {

  padlet: Padlet | undefined;
  entries: Entry[] | undefined;
  comment!: Comment[];
  showAddEntryForm: boolean = false;
  addEntryForm: FormGroup;

  constructor(private bs: PadletAppService,
              private route: ActivatedRoute,
              private router: Router,
              private toastr: ToastrService,
              public authService: AuthenticationService,
              private fb: FormBuilder) {
    this.addEntryForm = this.fb.group({});
  }

  ngOnInit() {
    const params = this.route.snapshot.params;
    this.bs.getSingle(params['padlet_id']).subscribe((b: Padlet) => {
      this.padlet = b;

      this.addEntryForm = this.fb.group({
        title: ['', Validators.required],
        description: ['', Validators.required],
        padlet_id: this.padlet?.id
      });

      this.bs.getEntries(params['padlet_id']).subscribe((b: Entry[]) => {
        this.entries = b;
        this.entries.forEach(entry => {
          this.getComments(entry);
        });
        this.entries.forEach(entry => {
          this.getRatings(entry);
        });
      });
    });


    // this.addEntryForm.statusChanges.subscribe(() =>
      // this.updateErrorMessages()
    // )
  }

  getRatingIcon(numStars: number): string {
    let icon = '';
    for (let i = 0; i < numStars; i++) {
      icon += '<i class="thumbs up icon green"></i>';
    }
    return icon;
  }

  getComments(entry: Entry) {
    this.bs.getComments(entry.id).subscribe(comments => {
      entry.comment = comments;
    })
  }

  getRatings(entry: Entry) {
    this.bs.getRatings(entry.id).subscribe(ratings => {
      entry.rating = ratings;
    });
  }

  addEntry(){
    this.showAddEntryForm = !this.showAddEntryForm;
  }

  submitForm(){
    this.bs.createEntry(this.addEntryForm.value).subscribe(res =>{
      this.entries?.push(res);
      this.showAddEntryForm = false;
    })
  }

  removeEntry(id: number) {
    if (confirm('Wollen Sie den Entry wirklich löschen?')) {
      this.bs.removeEntry(id).subscribe(
        (res: any) => {
          this.router.navigate(['../', this.padlet?.id],
            {relativeTo: this.route});
          window.location.reload();
          //Wird leider zu schnell wieder ausgeblendet
          this.toastr.success("Entry erfolgreich gelöscht", "Löschen");

        }
      )
    }
  }


}
