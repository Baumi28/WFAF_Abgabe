import {Entry} from "./entry";
export {Entry} from "./entry";


export class Padlet {
  constructor(public id:number,
              public title: string,
              public isPublic: boolean,
              public entries?: Entry[]) {
  }
}
