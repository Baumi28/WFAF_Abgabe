import {Component, EventEmitter, OnInit, Output} from '@angular/core';
import {Padlet} from "../shared/padlet";
import {PadletAppService} from "../shared/padlet-app.service";

@Component({
  selector: 'bs-padlet-list',
  templateUrl: './padlet-list.component.html',
  styles: []
})
export class PadletListComponent implements OnInit {
  padlets: Padlet[] = [];
  @Output() showDetailsEvent = new EventEmitter<Padlet>();


  constructor(private bs: PadletAppService) {
  }

  showDetails(padlet: Padlet) {
    this.showDetailsEvent.emit(padlet);
  }

  ngOnInit() {
    this.bs.getAll().subscribe(
      res => this.padlets = res
    );

  }
}
