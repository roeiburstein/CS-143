SELECT familyName FROM People GROUP BY familyName HAVING COUNT(*)>4;
