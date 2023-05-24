import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {HomeComponent} from "./home/home.component";
import {PadletDetailsComponent} from "./padlet-details/padlet-details.component";
import {PadletListComponent} from "./padlet-list/padlet-list.component";
import {PadletFormComponent} from "./padlet-form/padlet-form.component";

const routes: Routes = [
  {path: '', redirectTo: 'home', pathMatch:'full'},
  {path: 'home', component: HomeComponent},
  {path: 'padlets', component: PadletListComponent},
  {path: 'padlets/:padlet_id', component: PadletDetailsComponent},
  {path: 'padlets/:padlet_id/entries', component: PadletDetailsComponent},
  {path: 'admin', component: PadletFormComponent},
  {path: 'admin/:id', component: PadletFormComponent},
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
