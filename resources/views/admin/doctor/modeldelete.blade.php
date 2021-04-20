<div class="modal fade" id="exampleModal2{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Doctor information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                     <div class="card-body">
                    <img src="{{asset('images')}}/{{$user->image}}" width="120">
                    <h2>{{$user->name}}</h2>
                    <form class="forms-sample" action="{{route('doctor.destroy',[$user->id])}}" method="post" >@csrf
                        @method('DELETE')
                        <div class="card-footer">
                            <button type="submit" class="btn btn-danger mr-2">Confirm</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
            </div>
                  </div>
                </div>
              </div>
            </div>
