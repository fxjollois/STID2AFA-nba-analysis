matchs = NULL
liste = NULL
for (s in dir()) {
  m = as.integer(substr(dir(path = s, pattern = "00214[0-9]+"), 6, 10))
  liste = c(liste, m)
  if (length(m)>0) matchs = rbind(matchs, c(soiree = as.integer(s), deb = m[1], fin = m[length(m)]))
}
matchs = as.data.frame(matchs)
matchs$precedent = c(0, matchs$fin[-nrow(matchs)])
matchs$problem = (matchs$deb != matchs$precedent+1)
subset(matchs, problem == T)

sum(liste)-sum(1:length(liste))

