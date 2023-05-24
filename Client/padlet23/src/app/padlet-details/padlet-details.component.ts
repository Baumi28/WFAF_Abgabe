import {Component, OnInit} from '@angular/core';
import {Entry, Padlet} from '../shared/padlet';
import {PadletAppService} from "../shared/padlet-app.service";
import {ActivatedRoute, Router} from "@angular/router";
import {ToastrService} from "ngx-toastr";

@Component({
  selector: 'bs-padlet-details',
  templateUrl: './padlet-details.component.html',
  styles: []
})
export class PadletDetailsComponent implements OnInit {

  padlet: Padlet | undefined;
  entries: Entry[] | undefined;

  constructor(private bs: PadletAppService, private route: ActivatedRoute, private router: Router, private toastr: ToastrService) {
  }

  ngOnInit() {
    const params = this.route.snapshot.params;
    this.bs.getSingle(params['padlet_id']).subscribe(
      (b: Padlet) => this.padlet = b
    );

    this.bs.getEntries(params['padlet_id']).subscribe(
      (b: Entry[]) => this.entries = b
    );
    if (this.padlet) {
      this.entries = this.padlet.entries;
    }
  }

  getRating(num: number) {
    return new Array(num);
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
