import {Component, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {PadletFactory} from "../shared/padlet-factory";
import {PadletAppService} from "../shared/padlet-app.service";
import {ActivatedRoute, Router} from "@angular/router";
import {PadletFormErrorMessages} from "./padlet-form-error-messages";
import {Padlet} from "../shared/padlet";


@Component({
  selector: 'bs-padlet-form',
  templateUrl: './padlet-form.component.html',
  styles: []
})
export class PadletFormComponent implements OnInit {
  padlet = PadletFactory.empty();
  padletForm: FormGroup;
  isUpdatingPadlet = false;
  errors: { [key: string]: string } = {};

  constructor(private fb: FormBuilder, private bs: PadletAppService, private route: ActivatedRoute, private router: Router) {
    this.padletForm = this.fb.group({});
  }

  ngOnInit(): void {
    //Entscheiden ob neues Padlet angelegt werden soll oder ob bestehendes editiert werden soll
    const id = this.route.snapshot.params["id"];
    if (id) {
      //edit
      this.isUpdatingPadlet = true;
      this.bs.getSingle(id).subscribe(padlet => {
        this.padlet = padlet;
        this.initPadlet();
      })
    }
    this.initPadlet()

  }

  initPadlet() {
    this.padletForm = this.fb.group({
      isPublic: this.padlet.isPublic,
      title: [this.padlet.title, Validators.required]
    });
    this.padletForm.statusChanges.subscribe(() =>
      this.updateErrorMessages()
    )
  }

  updateErrorMessages() {
    this.errors = {};
    for (const message of PadletFormErrorMessages) {
      const control = this.padletForm.get(message.forControl);
      if (control && control.dirty && control.invalid && control.errors && control.errors[message.forValidator] && !this.errors[message.forControl]) {
        this.errors[message.forControl] = message.text;
      }
    }
  }

  submitForm() {
    console.log(this.padletForm.value);
    const padlet: Padlet = PadletFactory.fromObject(this.padletForm.value);

    if (this.isUpdatingPadlet) {

      this.bs.updatePadlet(padlet, this.route.snapshot.params["id"]).subscribe(res => {
        console.log("Bin im Update");
        this.router.navigate(["/padlets"])

      });
    } else {
      this.bs.createPadlet(padlet).subscribe(res => {
        console.log("Bin im Create");
        this.router.navigate(["/padlets"])
      })
    }
  }


}
