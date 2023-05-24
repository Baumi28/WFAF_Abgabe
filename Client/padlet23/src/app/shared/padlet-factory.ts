import {Entry, Padlet} from "./padlet";

export class PadletFactory {

  static empty():Padlet {
    return new Padlet(9, "Das erste dynamisch erstellte Padlet", true,
      [new Entry(7, "Siebter Eintrag", "Das ist der 7te Eintrag", 9)]);
  }

  static fromObject(rawPadlet:any):Padlet{
    return new Padlet(
      rawPadlet.id,
      rawPadlet.title,
      rawPadlet.isPublic
    )
  }
}
