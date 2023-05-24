import {Injectable} from '@angular/core';
import {Entry, Padlet} from "./padlet";
import {HttpClient} from "@angular/common/http";
import {catchError, Observable, retry, throwError} from "rxjs";

@Injectable({
  providedIn: 'root'
})
export class PadletAppService {
  private api = 'http://padlet23.s2010456002.student.kwmhgb.at/api'

  constructor(private http: HttpClient) {
  }

  getAll(): Observable<Array<Padlet>> {
    return this.http.get<Array<Padlet>>(`${this.api}/padlets`).pipe(retry(3)).pipe(catchError(this.errorHandler))
  }

  getSingle(id: number): Observable<Padlet> {
    return this.http.get<Padlet>(`${this.api}/padlets/${id}`).pipe(retry(3)).pipe(catchError(this.errorHandler))
  }

  getEntries(id: number): Observable<Array<Entry>> {
    return this.http.get<Array<Entry>>(`${this.api}/padlets/${id}/entries`).pipe(retry(3)).pipe(catchError(this.errorHandler))
  }

  private errorHandler(error: Error | any): Observable<any> {
    return throwError(error);
  }

  removePadlet(id: number): Observable<any> {
    return this.http.delete(`${this.api}/padlets/${id}`).pipe(retry(3)).pipe(catchError(this.errorHandler))
  }

  removeEntry(id: number): Observable<any> {
    return this.http.delete(`${this.api}/entries/${id}`).pipe(retry(3)).pipe(catchError(this.errorHandler))
  }

  createPadlet(padlet: Padlet): Observable<any> {
    return this.http.post(`${this.api}/padlets`, padlet).pipe(retry(3)).pipe(catchError(this.errorHandler))
  }

  updatePadlet(padlet: Padlet): Observable<any> {
    return this.http.post(`${this.api}/padlets/${padlet.id}`, padlet).pipe(retry(3)).pipe(catchError(this.errorHandler))
  }

}
