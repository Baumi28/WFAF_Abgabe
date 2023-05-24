import {Injectable} from '@angular/core';
import {Entry, Padlet} from "./padlet";
import {HttpClient} from "@angular/common/http";
import {catchError, Observable, retry, throwError} from "rxjs";
import {Rating} from "./rating";
import {Comment} from "./comment";

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

  getComments(id: number): Observable<Comment[]> {
    return this.http.get<Comment[]>(`${this.api}/entries/${id}/comments`).pipe(
      retry(3),
      catchError(this.errorHandler)
    );
  }

  getRatings(id: number): Observable<Rating[]> {
    return this.http.get<Rating[]>(`${this.api}/entries/${id}/ratings`).pipe(
      retry(3),
      catchError(this.errorHandler)
    );
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

  createEntry(entry: Entry): Observable<any>{
    return this.http.post(`${this.api}/entries`, entry).pipe(retry(3)).pipe(catchError(this.errorHandler))
  }

  createPadlet(padlet: Padlet): Observable<any> {
    console.log("Bin in der CreateRoute");
    return this.http.post(`${this.api}/padlets`, padlet).pipe(retry(3)).pipe(catchError(this.errorHandler))
  }

  updatePadlet(padlet: Padlet, id: Number): Observable<any> {
    console.log("Bin in den Routen");
    return this.http.put(`${this.api}/padlets/${id}`, padlet).pipe(retry(3)).pipe(catchError(this.errorHandler))
  }

  createComment(comment: Comment, id: Number): Observable<any> {
    console.log("Bin in der CreateRoute");
    return this.http.post(`${this.api}/entries/${id}/comments`, comment).pipe(retry(3)).pipe(catchError(this.errorHandler))
  }
}
