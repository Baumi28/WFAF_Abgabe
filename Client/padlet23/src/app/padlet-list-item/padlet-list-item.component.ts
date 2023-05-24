import {Component, Input} from '@angular/core';
import {Padlet} from "../shared/padlet";
import {ActivatedRoute, Router} from "@angular/router";
import {PadletFactory} from "../shared/padlet-factory";
import {PadletAppService} from "../shared/padlet-app.service";
import {ToastrService} from "ngx-toastr";


@Component({
  selector: 'a.bs-padlet-list-item',
  templateUrl: './padlet-list-item.component.html',
  styles: []
})
export class PadletListItemComponent {

  constructor(private router: Router, private bs:PadletAppService, private route: ActivatedRoute, private toastr: ToastrService) {
  }

  @Input() padlet = PadletFactory.empty();

  removePadlet() {
    if (confirm('Wollen Sie das Padlet wirklich löschen?')) {
      this.bs.removePadlet(this.padlet.id).subscribe(
        (res:any)=>{
          this.router.navigate(['/padlets'])
          this.toastr.success("Padlet erfolgreich gelöscht", "Löschen");
        });
    }
  }
}


