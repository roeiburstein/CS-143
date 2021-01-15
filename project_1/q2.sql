select Actor.first, Actor.last from Actor 
left join MovieActor on MovieActor.aid = Actor.id 
left join Movie on Movie.id = MovieActor.mid 
where Movie.title = 'Die Another Day';
