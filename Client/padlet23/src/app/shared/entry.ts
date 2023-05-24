import {Comment} from "./comment";
import {Rating} from "./rating";
export {Comment} from "./comment";
export {Rating} from "./rating";

export class Entry {
  constructor(public id:number,
              public title: string,
              public description: string,
              public padlet_id: number,
              public comment?: any[],
              public rating?: Rating[]) {
  }
}


