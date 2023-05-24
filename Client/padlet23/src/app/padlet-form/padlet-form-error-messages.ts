export class ErrorMessage {
  constructor(public forControl: string, public forValidator: string, public text: string) {
  }


}

export const PadletFormErrorMessages = [
  new ErrorMessage('title', 'required', 'Ein Buchtitel muss angegeben werden'),
  new ErrorMessage('isPublic', 'min', 'Die Zahl darf nur 0 (nicht öffentlich) oder 1 (öffentlich) sein'),
  new ErrorMessage('isPublic', 'max', 'Die Zahl darf nur 0 (nicht öffentlich) oder 1 (öffentlich) sein')
];
